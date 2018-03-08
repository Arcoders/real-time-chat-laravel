<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Friendship extends Model
{

    use SoftDeletes;

    protected $fillable = ['requester', 'requested', 'status'];

    public function scopeAccepted($query)
    {
        return $query->where('status', 1);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeWhereSender($query, $model)
    {
        return $query->where('requester', $model->getKey());
    }

    public function scopeWhereRecipient($query, $model)
    {
        return $query->where('requested', $model->getKey());
    }

    public function scopeBetweenUsers($query, $sender, $recipient)
    {
        $query->where(function ($queryIn) use ($sender, $recipient) {

            $queryIn->where(function ($q) use ($sender, $recipient) {

                $q->whereSender($sender)->whereRecipient($recipient);

            })->orWhere(function ($q) use ($sender, $recipient) {

                $q->whereSender($recipient)->whereRecipient($sender);

            });

        });
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'friend_chat');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requester');
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'requested');
    }

}
