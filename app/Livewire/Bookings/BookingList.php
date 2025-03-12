<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use App\Models\Student;
use App\Models\Instrument;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;

    public $search = '';
    public $studentSearch = '';
    public $instrumentSearch = '';
    public $status = 'All';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStudentSearch()
    {
        $this->resetPage();
    }

    public function updatingInstrumentSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function showForm()
    {
        $this->dispatch('showForm');
    }

    public function exportToPdf()
    {
        $query = Booking::query()->with(['student', 'instrument', 'slot'])->latest();
        $bookings = $query->get();
        $pdf = Pdf::loadView('exports.booking-pdf', ['bookings' => $bookings]);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'bookings.pdf');
    }

    public $showCancelModal = false;
    public $selectedBooking = null;
    public $cancellationRemark = '';

    public function cancelBooking($bookingId)
    {
        $this->selectedBooking = Booking::with('slot')->find($bookingId);
        $bookingDateTime = $this->selectedBooking->date . ' ' . $this->selectedBooking->slot->start_time;
        $fourHoursBefore = date('Y-m-d H:i:s', strtotime($bookingDateTime . ' -4 hours'));

        if (now() >= $fourHoursBefore) {

            $this->dispatch('toastError', 'Cannot cancel booking within 4 hours of the booking time.');

            return;
        }

        $this->showCancelModal = true;
    }

    public function confirmCancellation()
    {
        $this->validate([
            'cancellationRemark' => 'required|min:10',
        ]);

        $this->selectedBooking->update([
            'status' => 'cancelled',
            'description' => $this->cancellationRemark
        ]);

        $this->showCancelModal = false;
        $this->selectedBooking = null;
        $this->cancellationRemark = '';
        $this->dispatch('toastSuccess', 'Booking has been cancelled successfully.');
    }

    public function render()
    {
        $query = Booking::query()->with(['student', 'instrument', 'slot'])->latest();

//        $query = Booking::query()->with(['student', 'instrument', 'slot'])->where('student_id', 1)->latest();

        // Apply general search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('student', function($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('instrument', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Apply student-specific search
        if ($this->studentSearch) {
            $query->whereHas('student', function($q) {
                $q->where('first_name', 'like', '%' . $this->studentSearch . '%')
                  ->orWhere('last_name', 'like', '%' . $this->studentSearch . '%');
            });
        }

        // Apply instrument-specific search
        if ($this->instrumentSearch) {
            $query->whereHas('instrument', function($q) {
                $q->where('name', 'like', '%' . $this->instrumentSearch . '%');
            });
        }

        // Apply status filter
        if ($this->status !== 'All') {
            $query->where('status', $this->status);
        }


        return view('livewire.bookings.booking-list', [
            'bookings' => $query->paginate(10),
            'students' => Student::orderBy('first_name')->get(),
            'instruments' => Instrument::orderBy('name')->get()
        ]);
    }
}
