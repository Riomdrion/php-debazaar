<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerhuurAdvertentie extends Model
{
    use HasFactory;

    protected $table = 'verhuur_advertenties';

    protected $fillable = [
        'titel',
        'beschrijving',
        'dagprijs',
        'borg',
        'is_actief',
        'qr_code',
        'user_id',
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
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    // Koppelingen naar andere advertenties
    public function koppelingen()
    {
        return $this->hasMany(AdvertentieKoppeling::class, 'advertentie_id');
    }

    // Gekoppelde advertenties (via pivot-achtige relatie)
    public function gekoppeldeAdvertenties()
    {
        return $this->belongsToMany(
            Advertentie::class,
            'advertentie_koppelingen',
            'advertentie_id',
            'gekoppeld_id'
        );
    }
}
