<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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

            $user->avatar = $this->processImage($request->file('avatar'), $user->id,'/images/profiles/');

        }

        if ($request->file('cover')) {

            $user->cover = $this->processImage($request->file('cover'), $user->id,'/images/profiles/', false);

        }

        $user->name = $request['name'];
        $user->status = $request['status'];
        $save = $user->save();

        if ($save) return response()->json('User edited successfully', 200);
    }

    protected function processImage($requestFile, $userId, $folder, $avatar = true)
    {

            $data = $requestFile;
            $image = Image::make($data);

            if ($avatar) $image->fit(500, 500);

            $image_name = time() . '_' . $userId . '.' . $data->getClientOriginalExtension();

            $image->save(public_path() . $folder . $image_name);

            return $folder.$image_name;

    }

}
