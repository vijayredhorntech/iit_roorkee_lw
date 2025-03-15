<?php

namespace App\Livewire\Student;

use App\Models\Booking;
use App\Models\Instrument;
use Livewire\Component;
use Livewire\WithPagination;

class StudentBookingTable extends Component
{
    use WithPagination;

    public $student;
    public $search_date = '';
    public $search_instrument = '';
    public $instruments;

    public function mount()
    {
        $this->instruments = Instrument::all();
    }

    public function getBookings()
    {
        $query = Booking::where('student_id', $this->student->id)
            ->with(['instrument', 'slot']);

        if ($this->search_date) {
            $query->whereDate('date', $this->search_date);
        }

        if ($this->search_instrument) {
            $query->where('instrument_id', $this->search_instrument);
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.student.student-booking-table', [
            'bookings' => $this->getBookings()
        ]);
    }
}
