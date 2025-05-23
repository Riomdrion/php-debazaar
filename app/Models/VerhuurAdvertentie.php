<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerhuurAdvertentie extends Model
{

    protected $table = 'verhuur_advertenties';

    protected $fillable = [
        'titel',
        'beschrijving',
        'dagprijs',
        'borg',
        'is_actief',
        'qr_code',
        'user_id',
        'vervangingswaarde',
    ];

    protected $casts = [
        'is_actief' => 'boolean',
        'dagprijs' => 'decimal:2',
        'borg' => 'decimal:2',
    ];

    // Relatie met de gebruiker
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Rentals (verhuur periodes)
    public function rental()
    {
        return $this->hasMany(Rental::class);
    }
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function favorieten()
    {
        return $this->hasMany(Favoriet::class);
    }

    public function AgendaItems()
    {
        return $this->hasMany(AgendaItem::class);
    }

    public function wearSetting()
    {
        return $this->hasOne(WearSetting::class);
    }
}
