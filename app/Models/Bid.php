<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'bedrag',
        'user_id',
        'advertentie_id',
        'WinningBid',
    ];
    protected $casts = [
        'WinningBid' => 'boolean',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function advertentie()
    {
        return $this->belongsTo(Advertentie::class);
    }
}
