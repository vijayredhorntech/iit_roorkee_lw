<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstrumentService extends Model
{

    protected $fillable = [
        'instrument_id',
        'service_type',
        'description',
        'cost',
        'next_service_date',
        'photos',
        'status',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
