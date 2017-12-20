<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = ['name', 'user_id'];

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
