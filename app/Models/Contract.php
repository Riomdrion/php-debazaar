<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['bedrijf_id', 'bestand', 'is_goedgekeurd'];

    public function bedrijf() {
        return $this->belongsTo(Bedrijf::class);
    }
    public function scopePending($query)
    {
        return $query->where('is_goedgekeurd', 0);
    }
}
