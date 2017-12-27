<?php

namespace App\Http\Controllers;
use App\Chat;
use App\Traits\TriggerPusher;
use Illuminate\Support\Facades\Auth;

class FriendshipsController extends Controller
{

    use TriggerPusher;

    public function check($id)
    {

        if (in_array($id, Auth::user()->friends()))
        {
            return $this->returnStatus('friends');
        }

        if (in_array($id, Auth::user()->pending_friend_requests()))
        {
            return $this->returnStatus('pending');
        }

        if (in_array($id, Auth::user()->pending_friend_requests_sent()))
        {
            return $this->returnStatus('waiting');
        }
        return $this->returnStatus('add');

    }

    public function addFriend($id)
    {
        $add = Auth::user()->add_friend($id);
        if ($add)
        {
            $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
            return response()->json($add, 200);
        }
    }

    public function acceptFriend($id)
    {

        $chat= new Chat();
        $chat->user_id = Auth::user()->id;
        $chat->friend_id = $id;

        if ($chat->save())
        {
            $accept = Auth::user()->accept_friends($id);
            if ($accept)
            {
                $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
                return response()->json($accept, 200);
            } else {
                $chat->delete();
            }
        } else {
            return response()->json('pending', 200);
        }

    }

    public function rejectFriendship($id)
    {
        $reject = Auth::user()->reject_friendships($id);
        if ($reject)
        {
            $this->triggerPusher('user'.$id, 'updateStatus', ['update' => true]);
            return response()->json($reject, 200);
        }
    }

    protected function returnStatus($type)
    {
        return response()->json([
            'status' => $type
        ], 200);
    }

}
