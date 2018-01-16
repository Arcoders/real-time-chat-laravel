<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = ['group_id', 'chat_id', 'body', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

}
