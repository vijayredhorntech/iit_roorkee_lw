<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $fillable = [
        'user_id',
        'principal_investigator_id',
        'profile_photo',
        'first_name',
        'last_name',
        'academic_id',
        'department',
        'year_of_study',
        'email',
        'alt_email',
        'mobile_number',
        'research_area',
        'address',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function principalInvestigator()
    {
        return $this->belongsTo(PrincipalInvestigator::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function confirmedBookings()
    {
        return $this->hasMany(Booking::class)->where('status', 'confirmed');
    }

    public function cancelledBookings()
    {
        return $this->hasMany(Booking::class)->where('status', 'cancelled');
    }
}
