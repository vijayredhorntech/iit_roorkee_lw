<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrincipalInvestigator extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'title',
        'first_name',
        'last_name',
        'department',
        'designation',
        'email',
        'alt_email',
        'phone',
        'mobile',
        'office_address',
        'specialization',
        'qualification',
        'profile_photo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function labs()
    {
        return $this->hasOne(Lab::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->title} {$this->first_name} {$this->last_name}";
    }
}
