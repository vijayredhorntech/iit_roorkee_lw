<?php

namespace App\Livewire;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Component;

class SuperAdminDashboard extends Component
{
    public $totalLabs= 0;
    public $totalPis= 0;
    public $totalStudents= 0;
    public $totalInstruments= 0;
    public $instrumentUnderMaintenance= 0;
    public $instrumentCategories = 0;
    public $activeBookings = 0;
    public $underService = 0;
    public $totalComplaints = 0;
    public $thisMonthCollection = 0;
    public $dayWiseBookings = [];
    public $topBookedInstruments = [];
    public $mostServicedInstruments = [];
    public $topStudentWithMostBookings = [];

    public function render()
    {
        $this->totalLabs = \App\Models\Lab::count();
        $this->totalPis = \App\Models\PrincipalInvestigator::count();
        $this->totalStudents = \App\Models\Student::count();
        $this->totalInstruments = \App\Models\Instrument::count();
        $this->instrumentUnderMaintenance = \App\Models\Instrument::where('operating_status', 'under_maintenance')->count();
        $this->instrumentCategories = \App\Models\InstrumentCategory::count();
        $this->underService= \App\Models\InstrumentService::where('status', 'pending')->count();
        $this->totalComplaints = \App\Models\InstrumentComplaint::where('status', 'pending')->count();

        // Get top 3 booked instruments
        $this->topBookedInstruments = Booking::where('status', 'confirmed')
            ->select('instrument_id')
            ->selectRaw('COUNT(*) as booking_count')
            ->with('instrument:id,name')
            ->groupBy('instrument_id')
            ->orderByDesc('booking_count')
            ->limit(3)
            ->get()
            ->map(function($booking) {
                return [
                    'name' => $booking->instrument->name,
                    'count' => $booking->booking_count
                ];
            })
            ->toArray();

        // Get active bookings (confirmed bookings after current date/time)
        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $this->activeBookings = Booking::where('status', 'confirmed')
            ->where(function($query) use ($currentDate, $currentTime) {
                $query->where('date', '>', $currentDate)
                    ->orWhere(function($q) use ($currentDate, $currentTime) {
                        $q->where('date', $currentDate)
                            ->whereHas('slot', function($sq) use ($currentTime) {
                                $sq->where('end_time', '>', $currentTime);
                            });
                    });
            })
            ->count();

        // Calculate this month's collection from completed bookings
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $completedBookings = Booking::where('status', 'confirmed')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where(function($query) use ($currentDate, $currentTime) {
                $query->where('date', '<', $currentDate)
                    ->orWhere(function($q) use ($currentDate, $currentTime) {
                        $q->where('date', $currentDate)
                            ->whereHas('slot', function($sq) use ($currentTime) {
                                $sq->where('end_time', '<=', $currentTime);
                            });
                    });
            })
            ->with(['instrument', 'slot'])
            ->get();

        $totalCollection = 0;
        foreach ($completedBookings as $booking) {
            // Get the per hour cost for the instrument
            $perHourCost = $booking->instrument->per_hour_cost;

            // For 30-minute slots, divide the per hour cost by 2
            $bookingCost = $perHourCost / 2; // Since each slot is 30 minutes

            // Add to total collection
            $totalCollection += $bookingCost;
        }

        $this->thisMonthCollection = round($totalCollection, 2);

        // Calculate day-wise booking counts for current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $dates = [];
        $confirmedCounts = [];
        $cancelledCounts = [];

        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $confirmedCount = Booking::whereDate('date', $date->toDateString())
                ->where('status', 'confirmed')
                ->count();
            $cancelledCount = Booking::whereDate('date', $date->toDateString())
                ->where('status', 'cancelled')
                ->count();

            $dates[] = $date->format('d M');
            $confirmedCounts[] = $confirmedCount;
            $cancelledCounts[] = $cancelledCount;
        }

        $this->dayWiseBookings = [
            'dates' => $dates,
            'confirmed' => $confirmedCounts,
            'cancelled' => $cancelledCounts
        ];

        // Get top 3 most serviced instruments
        $this->mostServicedInstruments = \App\Models\InstrumentService::select('instrument_id')
            ->selectRaw('COUNT(*) as service_count')
            ->with('instrument:id,name')
            ->where('status', 'completed')
            ->groupBy('instrument_id')
            ->orderByDesc('service_count')
            ->limit(3)
            ->get()
            ->map(function($service) {
                // Add safety check for null instrument
                return [
                    'name' => $service->instrument ? $service->instrument->name : 'Unknown Instrument #' . $service->instrument_id,
                    'count' => (int)$service->service_count // Ensure count is an integer
                ];
            })
            ->toArray();

        // Get top 3 students with most bookings
        $this->topStudentWithMostBookings = Booking::where('status', 'confirmed')
            ->select('student_id')
            ->selectRaw('COUNT(*) as booking_count')
            ->with('student:id,first_name,last_name')
            ->groupBy('student_id')
            ->orderByDesc('booking_count')
            ->limit(3)
            ->get()
            ->map(function($booking) {
                return [
                    'name' => $booking->student ? $booking->student->first_name . ' ' . $booking->student->last_name : 'Unknown Student #' . $booking->student_id,
                    'count' => (int)$booking->booking_count
                ];
            })
            ->toArray();

        return view('livewire.super-admin-dashboard');
    }
}
