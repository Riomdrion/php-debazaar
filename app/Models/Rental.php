<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    public function verhuurAdvertentie() {
        return $this->belongsTo(VerhuurAdvertentie::class);
    }

    public function huurder() {
        return $this->belongsTo(User::class, 'huurder_id');
    }
}
