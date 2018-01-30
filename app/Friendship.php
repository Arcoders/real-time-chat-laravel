<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{

    protected $fillable = ['requester', 'requested', 'status'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested');
    }

    public function requested()
    {
        return $this->belongsTo(User::class, 'requester');
    }

}
