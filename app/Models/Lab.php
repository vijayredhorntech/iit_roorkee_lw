<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = [
        'principal_investigator_id',
        'lab_image',
        'lab_name',
        'department',
        'building',
        'floor',
        'room_number',
        'type',
        'contact_number',
        'working_hours',
        'capacity',
        'description',
        'safety_guidelines',
        'notes',
        'status'
    ];


    public function instruments()
    {
        return $this->hasMany(Instrument::class);
    }

    public function principalInvestigator()
    {
        return $this->belongsTo(PrincipalInvestigator::class);
    }
}
