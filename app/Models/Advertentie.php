<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertentie extends Model
{
    protected $fillable = [
        'titel',
        'beschrijving',
        'prijs',
        'qr_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verhuurAdvertentie()
    {
        return $this->hasOne(VerhuurAdvertentie::class);
    }

    public function favorieten()
    {
        return $this->hasMany(Favoriet::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function gerelateerdeAdvertenties()
    {
        return $this->belongsToMany(Advertentie::class, 'advertentie_koppelingen', 'advertentie_id', 'gekoppeld_id');
    }
}
