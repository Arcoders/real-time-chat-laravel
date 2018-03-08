<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{

    use SoftDeletes;

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
