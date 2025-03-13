<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstrumentComplaint extends Model
{


    protected $fillable = [
        'instrument_id',
        'student_id',
        'booking_id',
        'subject',
        'description',
        'image',
        'status'
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
