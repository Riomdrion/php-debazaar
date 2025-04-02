<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'advertentie_id',
        'bedrijf_id',
        'verhuur_advertentie_id',
        'bericht',
        'rating'
    ];

    public function reviewable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function advertentie()
    {
        return $this->belongsTo(Advertentie::class);
    }
    public function bedrijfs()
    {
        return $this->belongsTo(Bedrijf::class);
    }
    public function verhuuradvertentie()
    {
        return $this->belongsTo(VerhuurAdvertentie::class);
    }


}
