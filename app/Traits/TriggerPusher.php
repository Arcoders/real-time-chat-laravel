<?php

namespace App\Traits;

use Pusher\Pusher;

trait TriggerPusher
{

    function triggerPusher($roomChannel, $event, $data)
    {
        $this->PusherAuth()->trigger($roomChannel, $event, $data);
    }

    protected function PusherAuth()
    {
        $id = "436290";
        $key = "60efd870de38efff2291";
        $secret = "abb5aae8d6cb88f1c4cb";
        $cluster = "eu";

        return new Pusher( $key, $secret, $id, array('cluster' => $cluster) );
    }

}