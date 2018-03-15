<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function count()
    {
        return response()->json(['total_notifications' => Auth::user()->unreadnotifications->count()], 200);
    }

    public function show()
    {
        $notification = Array();

        foreach (Auth::user()->notifications as $n):
            array_push($notification, ['info' => $n->data, 'data' => $n->created_at, 'read' => $n->read_at]);
        endforeach;

        return response()->json($notification, 200);
    }

    public function markAsRead()
    {
        $user = Auth::user();

        foreach ($user->unreadnotifications as $n):
            $n->markAsRead();
        endforeach;

        if ($user->notifications->count() >= 10) $user->notifications()->delete();

        return response()->json('done', 200);
    }
}
