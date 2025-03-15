<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstrumentAccessorie extends Model
{

    protected $fillable = [
        'instrument_id',
        'name',
        'model_number',
        'purchase_date',
        'price',
        'description',
        'status',
        'photo',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
