<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model
{
    protected $fillable = [
        'user_id',
        'verhuur_advertentie_id',
        'titel',
        'start',
        'eind',
        'type',
    ];
    protected $casts = [
        'start' => 'datetime',
        'eind' => 'datetime',
    ];

    public function verhuurAdvertentie()
    {
        return $this->belongsTo(VerhuurAdvertentie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
