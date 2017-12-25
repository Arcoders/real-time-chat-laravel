<?php

namespace App\Traits;

use Pusher\Pusher;

trait TriggerPusher
{

    function trigger_pusher($roomChannel, $event, $data)
    {
        $id = "436290";
        $key = "60efd870de38efff2291";
        $secret = "abb5aae8d6cb88f1c4cb";
        $cluster = "eu";

        $pusher = new Pusher( $key, $secret, $id, array('cluster' => $cluster) );
        $pusher->trigger($roomChannel, $event, $data);
    }

}