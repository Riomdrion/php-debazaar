<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function verhuurAdvertentie() {
        return $this->belongsTo(VerhuurAdvertentie::class);
    }
}
