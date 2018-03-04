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

    public function scopeAccepted($query, $val)
    {
        return $query->where('status', $val);
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

}
