<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

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

    public function countNotifications()
    {
        return response()->json(
            [
                'total_notifications' =>Auth::user()->unreadnotifications->count()
            ],
            200);
    }

    public function showNotifications()
    {

        $notification = Array();

        foreach (Auth::user()->unreadnotifications as $n):
            array_push($notification, ['info' => $n->data, 'data' => $n->created_at]);
        endforeach;

        return response()->json($notification, 200);

    }

}
