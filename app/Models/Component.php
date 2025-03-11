<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function bedrijf() {
        return $this->belongsTo(Bedrijf::class);
    }
}
