<?php

namespace App\Http\Controllers;

use App\Group;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{

    use UploadFiles;

    protected $folder = '/images/avatars/';

    public function newGroup(Request $request)
    {

        $request['id'] = $this->idsToArray($request['id']);

        $request->validate([
            'name' => 'required|unique:groups|min:4|max:15',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000',
            'id'  => 'required|array|min:1'
        ],
        [
            'id.required' => 'You must select at least one user'
        ]);

        $avatar_name = null;
        $user = Auth::user();

        if ($request->file('avatar')) {

            $avatar_name = $this->processImage($request->file('avatar'), $user->id, $this->folder);
        }

        $group = Group::create([
            'name' => $request['name'],
            'user_id' => $user->id,
            'avatar' => $avatar_name
        ]);

        $group->users()->sync($request['id']);

        if ($group) return response()->json("$group->name created successfully", 200);
    }

    public function myGroups()
    {
        $groups = Group::where('user_id', Auth::user()->id)->paginate(4);

        return response()->json($groups, 200);
    }

    public function deleteGroup($group_id)
    {
        $query = Group::where('id', $group_id)->where('user_id', Auth::user()->id);
        $group = $query->first();

        if ($group->avatar) $this->deleteImage($group->avatar);

        $group->users()->detach();

        $delete = $query->delete();

        if ($delete) return response()->json("$group->name was deleted", 200);
    }

    public function getGroup($group_id)
    {
        $group = Group::where('id', $group_id)
                ->where('user_id', Auth::user()->id)
                ->with('users')
                ->first();

        if ($group) return response()->json($group, 200);
    }

    public function listFriends()
    {
        $friends = Auth::user()->friends(true);

        if ($friends) return response($friends,200);
    }

    public function editGroup($group_id, Request $request)
    {
        $user = Auth::user();
        $group = Group::find($group_id);

        if ($request['deleteImage']) {

            $this->deleteImage($group->avatar);

            $group->avatar = null;
        }

        $request['id'] = $this->idsToArray($request['id']);

        $request->validate([
            'name' => 'required|min:4|max:15|unique:groups,name,'.$group->id,
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000',
            'id'  => 'required|array|min:1'
        ],
        [
            'id.required' => 'You must select at least one user'
        ]);

        if ($request->file('avatar')) {

            $this->deleteImage($group->avatar);

            $group->avatar = $this->processImage($request->file('avatar'), $user->id, $this->folder);

        }

        $group->name = $request['name'];

        $save = $group->save();

        $group->users()->sync($request['id']);

        if ($save) return response()->json('Group edited successfully', 200);
    }

    protected function idsToArray($request)
    {
        return $request ? explode(',', $request) : [];
    }

    public function listChatsGroup()
    {
        $groups = Auth::user()->groups;

        if ($groups) return response()->json($groups, 200);
    }

}