<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'agenda_item_id',
        'slijtage_kosten',
        'retour_foto',
    ];
    public function AgendaItem()
    {
        return $this->belongsTo(AgendaItem::class);
    }

}
