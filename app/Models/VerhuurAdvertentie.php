<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerhuurAdvertentie extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function agendaItems() {
        return $this->hasMany(AgendaItem::class);
    }

    public function rentals() {
        return $this->hasMany(Rental::class);
    }

    public function reviews() {
        return $this->morphMany(Review::class, 'reviewable');
    }
    public function advertentie()
    {
        return $this->belongsTo(Advertentie::class);
    }
}
