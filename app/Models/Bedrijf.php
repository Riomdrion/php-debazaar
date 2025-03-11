<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bedrijf extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function components() {
        return $this->hasMany(Component::class);
    }

    public function contracts() {
        return $this->hasMany(Contract::class);
    }
}
