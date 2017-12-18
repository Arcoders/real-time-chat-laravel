<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineGroup extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function onlineGroup()
    {
        return $this->hasOne(OnlineGroup::class);
    }

}
