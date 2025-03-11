<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstrumentCategory extends Model
{
    protected $table = 'instrument_categories';
    protected $fillable = ['name', 'description'];

    public function instruments()
    {
        return $this->hasMany(Instrument::class);
    }
}
