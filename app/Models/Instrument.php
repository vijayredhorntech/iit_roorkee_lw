<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{

    protected $fillable = [
        'instrument_category_id',
        'lab_id',
        'name',
        'model_number',
        'serial_number',
        'description',
        'operating_status',
        'per_hour_cost',
        'minimum_booking_duration',
        'maximum_booking_duration',
        'photos',
        'operational_manual',
        'service_manual',
        'video_link',
    ];


    public function instrumentCategory()
    {
        return $this->belongsTo(InstrumentCategory::class);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}
