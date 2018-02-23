<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function myNotifications()
    {
        return response()->json(
            [
                'total_notifications' =>Auth::user()->unreadnotifications->count()
            ], 200);

//        foreach (Auth::user()->unreadnotifications as $n):
//            return $n->data ;
//        endforeach;

    }

}
