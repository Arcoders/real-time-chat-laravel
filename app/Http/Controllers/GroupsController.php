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

        $user = Auth::user();

        if ($request->file('avatar')) {


            $data = $request->file('avatar');

            $avatar = Image::make($data);
            $avatar->fit(200, 200);

            $avatar_name = time() . '_' . $user->id . '_' . $data->getClientOriginalName();

            return $avatar_name;

        }

        $create = Group::create([
            'name' => $request['name'],
            'user_id' => $user->id,
            'avatar' => $avatar_name
        ]);

        if ($create) return response()->json('Group created successfully', 200);

    }

}
