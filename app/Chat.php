<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class);
    }


}
