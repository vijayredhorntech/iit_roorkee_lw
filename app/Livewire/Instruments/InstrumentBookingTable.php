<?php

namespace App\Livewire\Instruments;

use App\Models\Booking;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class InstrumentBookingTable extends Component
{
    use WithPagination;

    public $instrument;
    public $search = '';
    public $studentSearch = '';
    public $status = 'All';

    public function mount($instrument)
    {
        $this->instrument = $instrument;
    }

    public function hideForm()
    {
        $this->dispatch('hideForm');
    }

    public function exportToPdf()
    {
        $bookings = $this->getFilteredBookings()->get();
        $pdf = Pdf::loadView('livewire.instruments.booking-export-pdf', [
            'bookings' => $bookings,
            'instrument' => $this->instrument
        ]);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'bookings.pdf');
    }

    public function cancelBooking($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status' => 'cancelled']);
        }
    }

    public function raiseComplaint($bookingId)
    {
        $this->dispatch('openComplaintForm', bookingId: $bookingId);
    }

    private function getFilteredBookings()
    {
        return Booking::where('instrument_id', $this->instrument->id)
            ->when($this->search, function($query) {
                $query->whereHas('student', function($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('academic_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->studentSearch, function($query) {
                $query->whereHas('student', function($q) {
                    $q->where('first_name', $this->studentSearch);
                });
            })
            ->when($this->status !== 'All', function($query) {
                $query->where('status', $this->status);
            })
            ->latest();
    }

    public function render()
    {
        $bookings = $this->getFilteredBookings()->paginate(10);
        $students = Student::all();

        return view('livewire.instruments.instrument-booking-table', [
            'bookings' => $bookings,
            'students' => $students
        ]);
    }
}
