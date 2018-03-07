<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Online extends Model
{

    protected $fillable = ['group_chat', 'user_id', 'friend_chat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function online()
    {
        return $this->hasOne(Online::class);
    }

}
