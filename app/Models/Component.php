<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = ['bedrijf_id', 'type', 'data', 'order'];

    protected $casts = [
        'data' => 'array',
    ];

    public function bedrijf()
    {
        return $this->belongsTo(Bedrijf::class, 'bedrijf_id');
    }
}
