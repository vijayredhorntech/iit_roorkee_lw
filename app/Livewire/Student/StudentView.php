<?php

namespace App\Livewire\Student;

use App\Models\Booking;
use App\Models\Instrument;
use Livewire\Component;

class StudentView extends Component
{
    public $student;
    public $bookings;
    public $search_date = '';
    public $search_instrument = '';
    public $instruments;

    public function mount()
    {
        $this->instruments = Instrument::all();
        $this->loadBookings();
    }

    public function loadBookings()
    {
        $query = Booking::where('student_id', $this->student->id)
            ->with(['instrument', 'slot']);

        if ($this->search_date) {
            $query->whereDate('date', $this->search_date);
        }

        if ($this->search_instrument) {
            $query->where('instrument_id', $this->search_instrument);
        }

        $this->bookings = $query->latest()->get();
    }

    public function updatedSearchDate()
    {
        $this->loadBookings();
    }

    public function updatedSearchInstrument()
    {
        $this->loadBookings();
    }

    public function hideViewStudent()
    {
        $this->dispatch('hideViewStudent');
    }

    public function render()
    {
        return view('livewire.student.student-view');
    }
}