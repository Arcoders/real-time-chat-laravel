<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{

    protected $fillable = ['requester', 'user_requested', 'status'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'user_requested');
    }

    public function requested()
    {
        return $this->belongsTo(User::class, 'requester');
    }

}
