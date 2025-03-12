<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = ['instrument_id', 'student_id', 'slot_id', 'date', 'status'];


    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
