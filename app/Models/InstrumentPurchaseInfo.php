<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstrumentPurchaseInfo extends Model
{

    protected $fillable = [
        'instrument_id',
        'manufacturer_name',
        'vendor_name',
        'manufacturing_date',
        'purchase_date',
        'purchase_order_number',
        'cost',
        'funding_source',
        'installation_date',
        'warranty_period',
        'next_service_date',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
