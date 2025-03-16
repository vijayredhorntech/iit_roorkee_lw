<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use App\Models\Student;
use App\Models\Instrument;
use App\Models\InstrumentComplaint;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $studentSearch = '';
    public $instrumentSearch = '';
    public $status = 'All';
    public $studentView = false;

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

    // Complaint Modal Properties
    public $showComplaintModal = false;
    public $complaintSubject = '';
    public $complaintDescription = '';
    public $complaintImage = null;
    public $complaintBooking = null;

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
            'cancellationRemark' => 'required',
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

    public function raiseComplaint($bookingId)
    {
        $this->complaintBooking = Booking::with('slot')->find($bookingId);
        $bookingDateTime = $this->complaintBooking->date . ' ' . $this->complaintBooking->slot->start_time;
        $slotStartTime = strtotime($bookingDateTime);
        $fifteenMinutesAfterStart = strtotime('+15 minutes', $slotStartTime);

        if (time() < $slotStartTime || time() > $fifteenMinutesAfterStart) {
            $this->dispatch('toastError', 'Complaints can only be raised within 15 minutes of slot start time.');
            return;
        }

        // Check if a complaint already exists for this booking
        $existingComplaint = InstrumentComplaint::where('booking_id', $bookingId)->first();
        if ($existingComplaint) {
            $this->dispatch('toastError', 'A complaint has already been registered for this booking.');
            return;
        }

        $this->showComplaintModal = true;
    }

    public function submitComplaint()
    {
        $this->validate([
            'complaintSubject' => 'required|min:5',
            'complaintDescription' => 'required|min:10',
            'complaintImage' => 'nullable|image|max:1024',
        ]);

        $imagePath = null;
        if ($this->complaintImage) {
            $imagePath = $this->complaintImage->store('complaint-images', 'public');
        }

        InstrumentComplaint::create([
            'instrument_id' => $this->complaintBooking->instrument_id,
            'student_id' => $this->complaintBooking->student_id,
            'booking_id' => $this->complaintBooking->id,
            'subject' => $this->complaintSubject,
            'description' => $this->complaintDescription,
            'image' => $imagePath,
            'status' => 'pending'
        ]);

        $this->showComplaintModal = false;
        $this->complaintBooking = null;
        $this->complaintSubject = '';
        $this->complaintDescription = '';
        $this->complaintImage = null;

        $this->dispatch('toastSuccess', 'Complaint has been submitted successfully.');
    }

    public function render()
    {


        if (auth()->user()->hasRole('super_admin')) {
            $query = Booking::query()->with(['student', 'instrument', 'slot'])->latest();
        } elseif (auth()->user()->hasRole('pi')) {
            $query = Booking::whereHas('student', function($q) {
                $q->where('principal_investigator_id', auth()->user()->principalInvestigators->first()->id);
            })->with(['student', 'instrument', 'slot'])->latest();
        } elseif (auth()->user()->hasRole('student')) {

            $this->studentView = true;
            $query = Booking::where('student_id', auth()->user()->students->first()->id)->with(['student', 'instrument', 'slot'])->latest();
        }


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
