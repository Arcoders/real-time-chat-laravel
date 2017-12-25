<?php

namespace App\Http\Controllers;

use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    use UploadFiles;

    protected $folder = '/images/profiles/';

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

    public function editProfile(Request $request)
    {

        $user= Auth::user();

        $request->validate([
            'name' => 'required|min:4|max:15',
            'status' => 'required|min:4|max:30',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:1000',
            'cover' => 'image|mimes:jpeg,jpg,png,gif|max:1000'
        ]);

        if ($request->file('avatar')) {

            $this->deleteImage($user->avatar);

            $user->avatar = $this->processImage($request->file('avatar'), $user->id, $this->folder);

        }

        if ($request->file('cover')) {

            $this->deleteImage($user->cover);

            $user->cover = $this->processImage($request->file('cover'), $user->id, $this->folder, false);

        }

        $user->name = $request['name'];
        $user->status = $request['status'];

        $save = $user->save();

        if ($save) return response()->json('User edited successfully', 200);
    }

}
