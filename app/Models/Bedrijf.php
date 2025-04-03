<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Bedrijf extends Model
{
    /** @use HasFactory<\Database\Factories\BedrijfFactory> */
    use HasFactory, Notifiable;

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
    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
