<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bedrijf extends Model
{
    // Specify which fields can be mass assigned
    protected $fillable = [
        'naam',         // Add 'naam' to allow mass assignment
        'custom_url',   // Add 'custom_url' to allow mass assignment
        'user_id',      // Add 'user_id' if you also want to allow assignment during relationship linking
    ];

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
