<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function chatsList()
    {
        return response()->json([
            'groups' => Auth::user()->groups,
            'friends' => Auth::user()->friends(true)
        ], 200);
    }

}
