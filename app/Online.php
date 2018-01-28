<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Online extends Model
{

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
