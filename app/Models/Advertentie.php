<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertentie extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reviews() {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function bids() {
        return $this->hasMany(Bid::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }
}
