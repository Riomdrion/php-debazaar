<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertentieKoppeling extends Model
{

    protected $table = 'advertentie_koppelingen';

    protected $fillable = [
        'advertentie_id',
        'gekoppeld_id',
    ];

    public function advertentie(): BelongsTo
    {
        return $this->belongsTo(Advertentie::class, 'advertentie_id');
    }

    public function gekoppeld()
    {
        return $this->belongsTo(Advertentie::class, 'advertentie_id');
    }
}
