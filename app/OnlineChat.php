<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineChat extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
    public function onlineChat()
    {
        return $this->hasOne(OnlineChat::class);
    }

}
