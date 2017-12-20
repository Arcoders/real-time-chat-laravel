<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{

    public function newGroup(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:groups|min:4|max:15'
        ]);

        $create = Group::create([
            'name' => $request['name'],
            'user_id' => Auth::user()->id
        ]);

        if ($create) return response()->json('Group created successfully', 200);

    }

}
