<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WearSetting extends Model
{
    protected $table = 'wear_settings';
    protected $fillable = [
        'verhuur_advertentie_id',
        'slijtage_per_dag',
        'slijtage_per_verhuur',
        'categorie_modifier',
    ];

    public function verhuurAdvertentie()
    {
        return $this->belongsTo(VerhuurAdvertentie::class);
    }
}
