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
        'engineer_name',
        'engineer_email',
        'engineer_mobile',
        'engineer_address',
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

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function instrumentAccessories()
    {
        return $this->hasMany(InstrumentAccessorie::class);
    }

    public function purchaseInformation()
    {
        return $this->hasOne(InstrumentPurchaseInfo::class);
    }

    public function getNextBookingDateTime()
    {
        $today = now()->toDateString();
        $currentTime = now()->format('H:i:s');

        $nextBooking = $this->bookings()
            ->join('slots', 'bookings.slot_id', '=', 'slots.id')
            ->where(function($query) use ($today, $currentTime) {
                // Future dates
                $query->where('bookings.date', '>', $today)
                    // Or today but future time
                    ->orWhere(function($q) use ($today, $currentTime) {
                        $q->where('bookings.date', '=', $today)
                            ->whereRaw('slots.start_time > ?', [$currentTime]);
                    });
            })
            ->where('bookings.status', 'confirmed')
            ->orderBy('bookings.date', 'asc')
            ->orderBy('slots.start_time', 'asc')
            ->select('bookings.*', 'slots.start_time', 'slots.end_time')
            ->first();

        if ($nextBooking) {
            // Format the date and time for display
            $bookingDate = \Carbon\Carbon::parse($nextBooking->date)->format('d M Y');
            $startTime = \Carbon\Carbon::parse($nextBooking->start_time)->format('h:i A');

            return $bookingDate . ', ' . $startTime;
        }

        return 'No upcoming bookings';
    }

    public function getNextAvailableSlot()
    {
        $today = now()->toDateString();
        $currentTime = now()->format('H:i:s');

        // Get the first available slot
        $nextSlot = Slot::orderBy('start_time')
            ->whereNotExists(function ($query) use ($today) {
                $query->from('bookings')
                    ->whereColumn('bookings.slot_id', 'slots.id')
                    ->where('bookings.instrument_id', $this->id)
                    ->where('bookings.date', $today)
                    ->where('bookings.status', 'confirmed');
            })
            ->when($today === now()->toDateString(), function ($query) use ($currentTime) {
                return $query->where('start_time', '>', $currentTime);
            })
            ->first();

        if ($nextSlot) {
            $formattedDate = now()->format('d M Y');
            $startTime = \Carbon\Carbon::parse($nextSlot->start_time)->format('h:i A');
            return "$formattedDate, $startTime";
        }

        // If no slot available today, check tomorrow
        $tomorrow = now()->addDay()->toDateString();
        $nextSlot = Slot::orderBy('start_time')
            ->whereNotExists(function ($query) use ($tomorrow) {
                $query->from('bookings')
                    ->whereColumn('bookings.slot_id', 'slots.id')
                    ->where('bookings.instrument_id', $this->id)
                    ->where('bookings.date', $tomorrow)
                    ->where('bookings.status', 'confirmed');
            })
            ->first();

        if ($nextSlot) {
            $formattedDate = now()->addDay()->format('d M Y');
            $startTime = \Carbon\Carbon::parse($nextSlot->start_time)->format('h:i A');
            return "$formattedDate, $startTime";
        }

        return 'No available slots'; // No available slots found for today or tomorrow
    }
}
