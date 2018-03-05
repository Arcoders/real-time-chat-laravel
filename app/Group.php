<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = ['name', 'user_id', 'avatar'];

    public function messages()
    {
        return $this->hasMany(Message::class, 'group_chat');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('group_id', 'user_id');
    }

}
