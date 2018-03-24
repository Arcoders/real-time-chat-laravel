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

    public function user(User $user)
    {
        return response()->json($user, 200);
    }

    public function users()
    {
        $friends = Auth::user()->friends('ids');

        array_push($friends, Auth::id());

        return response()->json(User::all()->except($friends)->random(8), 200);
    }

    public function edit(Request $request)
    {

        $user= Auth::user();

        $request->validate([
            'name' => 'required|min:4|max:25',
            'status' => 'required|min:4|max:70',
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

        if ($save) return response()->json([
            'user' => $user,
            'info' => 'User edited successfully'
        ], 200);
    }

}
