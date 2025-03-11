<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoriet extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function advertentie() {
        return $this->belongsTo(Advertentie::class);
    }
}
