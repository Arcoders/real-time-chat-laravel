<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function onlineGroup()
    {
        return $this->hasMany(OnlineGroup::class);
    }

}
