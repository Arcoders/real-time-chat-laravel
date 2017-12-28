<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function chatsList()
    {
        $groups = Auth::user()->groups;

        if ($groups) return response()->json($groups, 200);
    }

}
