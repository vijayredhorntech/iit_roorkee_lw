<?php

namespace App\Livewire\Instruments;

use App\Models\InstrumentComplaint as InstrumentComplaintModel;
use App\Models\Student;
use App\Models\Instrument;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class InstrumentComplaint extends Component
{
    use WithPagination;

    public $search = '';
    public $studentSearch = '';
    public $instrumentSearch = '';
    public $status = 'All';

    // Status Update Modal Properties
    public $showStatusModal = false;
    public $selectedComplaint = null;
    public $complaintStatus = '';
    public $complaintRemark = '';

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

    public function updateStatus($complaintId)
    {
        $this->selectedComplaint = InstrumentComplaintModel::with('booking')->find($complaintId);
        $this->complaintStatus = $this->selectedComplaint->status;
        $this->complaintRemark = $this->selectedComplaint->remark;
        $this->showStatusModal = true;
    }

    public function confirmStatusUpdate()
    {
        $this->validate([
            'complaintStatus' => 'required|in:pending,approved,rejected',
            'complaintRemark' => 'required',
        ]);

        $this->selectedComplaint->update([
            'status' => $this->complaintStatus,
            'remark' => $this->complaintRemark
        ]);

        // If status is approved, cancel the associated booking and update instrument status
        if ($this->complaintStatus === 'approved') {
            if ($this->selectedComplaint->booking) {
                $this->selectedComplaint->booking->update([
                    'status' => 'cancelled',
                    'description' => 'Cancelled due to approved complaint: ' . $this->complaintRemark
                ]);
            }
            
            // Update instrument status to under maintenance
            $this->selectedComplaint->instrument->update([
                'operating_status' => 'under_maintenance'
            ]);
        }

        $this->showStatusModal = false;
        $this->selectedComplaint = null;
        $this->complaintStatus = '';
        $this->complaintRemark = '';
        $this->dispatch('toastSuccess', 'Complaint status has been updated successfully.');
    }

    public function exportToPdf()
    {
        if (auth()->user()->hasRole('super_admin')) {
            $query = InstrumentComplaintModel::query()->with(['student', 'instrument', 'booking'])->latest();
        } elseif (auth()->user()->hasRole('pi')) {
            $query = InstrumentComplaintModel::whereHas('student', function($q) {
                $q->where('principal_investigator_id', auth()->user()->principalInvestigators->first()->id);
            })->with(['student', 'instrument', 'booking'])->latest();
        } elseif (auth()->user()->hasRole('student')) {
            $query = InstrumentComplaintModel::where('student_id', auth()->user()->students->first()->id)
                ->with(['student', 'instrument', 'booking'])->latest();
        }

        $complaints = $query->get();
        $pdf = Pdf::loadView('exports.complaint-pdf', ['complaints' => $complaints]);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'complaints.pdf');
    }

    public function render()
    {
        if (auth()->user()->hasRole('super_admin')) {
            $query = InstrumentComplaintModel::query()->with(['student', 'instrument', 'booking'])->latest();
        } elseif (auth()->user()->hasRole('pi')) {
            $query = InstrumentComplaintModel::whereHas('student', function($q) {
                $q->where('principal_investigator_id', auth()->user()->principalInvestigators->first()->id);
            })->with(['student', 'instrument', 'booking'])->latest();
        } elseif (auth()->user()->hasRole('student')) {
            $query = InstrumentComplaintModel::where('student_id', auth()->user()->students->first()->id)
                ->with(['student', 'instrument', 'booking'])->latest();
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('student', function($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('instrument', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('subject', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->studentSearch) {
            $query->whereHas('student', function($q) {
                $q->where('first_name', 'like', '%' . $this->studentSearch . '%')
                  ->orWhere('last_name', 'like', '%' . $this->studentSearch . '%');
            });
        }

        if ($this->instrumentSearch) {
            $query->whereHas('instrument', function($q) {
                $q->where('name', 'like', '%' . $this->instrumentSearch . '%');
            });
        }

        if ($this->status !== 'All') {
            $query->where('status', $this->status);
        }

        return view('livewire.instruments.instrument-complaint', [
            'complaints' => $query->paginate(10),
            'students' => Student::orderBy('first_name')->get(),
            'instruments' => Instrument::orderBy('name')->get()
        ]);
    }
}
