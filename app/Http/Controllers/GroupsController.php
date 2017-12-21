<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class GroupsController extends Controller
{

    public function newGroup(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:groups|min:4|max:15',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000'
        ]);

        $avatar_name = null;
        $user = Auth::user();

        if ($request->file('avatar')) {


            $data = $request->file('avatar');

            $avatar = Image::make($data);
            $avatar->fit(500, 500);

           $avatar_name = time() . '_' . $user->id . '_' . $data->getClientOriginalName();

            $avatar->save(public_path() . '/images/avatars/' . $avatar_name);

        }

        $create = Group::create([
            'name' => $request['name'],
            'user_id' => $user->id,
            'avatar' => $avatar_name
        ]);

        if ($create) return response()->json('Group created successfully', 200);

    }

    public function myGroups()
    {
        $groups = Group::where('user_id', Auth::user()->id)->get();
        return response()->json($groups, 200);
    }

    public function deleteGroup($group_id)
    {
        $query = Group::where('id', $group_id)->where('user_id', Auth::user()->id);

        $group = $query->first();

        if ($group->avatar) {

            $file = public_path() . '/images/avatars/' . $group->avatar;
            if (file_exists($file)) @unlink($file);

        }

        $delete = $query->delete();

        if ($delete) return response()->json('Group was deleted', 200);
    }

    public function getGroup($group_id)
    {
        $group = Group::where('id', $group_id)->where('user_id', Auth::user()->id)->first();

        if ($group) return response()->json($group, 200);
    }

    public function update($group_id, Request $request)
    {

        $user = Auth::user();
        $group = Group::find($group_id);

        $request->validate([
            'name' => 'required|min:4|max:15|unique:groups,name,'.$group->id,
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000'
        ]);

        if ($request->file('avatar')) {

            // Delete current image

            $file = public_path() . '/images/avatars/' . $group->avatar;
            if (file_exists($file)) @unlink($file);

            // Create new image

            $data = $request->file('avatar');
            $avatar = Image::make($data);
            $avatar->fit(500, 500);

            $avatar_name = time() . '_' . $user->id . '_' . $data->getClientOriginalName();

            $avatar->save(public_path() . '/images/avatars/' . $avatar_name);

            $group->avatar = $avatar_name;

        }

        $group->name = $request['name'];
        $save = $group->save();

        if ($save) return response()->json('Group edited successfully', 200);
    }

}
