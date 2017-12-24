<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{

    public function getProfile($profile_id)
    {
        $profile = User::find($profile_id);

        if ($profile) return response()->json($profile, 200);
    }

    public function getUsers()
    {
        $users = User::all()->except(Auth::id());

        if ($users) return response()->json($users, 200);
    }

    public function editGroup($profile_id, Request $request)
    {

        $user= User::find($profile_id);

        $request->validate([
            'name' => 'required|min:4|max:15',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000'
        ]);

        if ($request->file('avatar')) {

            // Create new image

            $data = $request->file('avatar');
            $avatar = Image::make($data);
            $avatar->fit(500, 500);

            $avatar_name = time() . '_' . $user->id . '.' . $data->getClientOriginalExtension();

            $avatar->save(public_path() . '/images/avatars/' . $avatar_name);

            $user->avatar = $avatar_name;

        }

        $group->name = $request['name'];
        $save = $group->save();

        if ($save) return response()->json('Group edited successfully', 200);
    }

}
