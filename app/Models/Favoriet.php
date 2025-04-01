<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoriet extends Model
{
    protected $table = 'favorites';
    protected $fillable = ['user_id', 'advertentie_id'];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function advertentie() {
        return $this->belongsTo(Advertentie::class);
    }
    public function verhuurAdvertentie() {
        return $this->belongsTo(VerhuurAdvertentie::class);
    }
}
