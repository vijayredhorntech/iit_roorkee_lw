<?php

namespace App\Livewire\Pi;

use App\Models\PrincipalInvestigator;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PiExport;

class PiList extends Component
{
    use WithPagination; // Add this trait to enable pagination

    public $showForm = false;
    public $search = '';
    public $status = 'All';
    public $totalPi = 0;
    public $activePi = 0;
    public $inactivePi = 0;
    public $isEditing = false;
    public $piId = null;
    public $viewPiDetailView =false;
    public $showPiStudents = false;
    public $selectedPi = null;
    public $studentList = null;

    // Event listener for the form submission
    protected $listeners = [
        'piCreated' => 'handlePiCreated',
        'piUpdated' => 'handlePiUpdated',
        'hideViewPi' => 'handleHideViewPi',
    ];

    public $viewPiDetails;

    public function hideForm()
    {
        $this->showForm = !$this->showForm;

        if (!$this->showForm) {
            $this->isEditing = false;
            $this->piId = null;
            $this->dispatch('resetForm');
        }
    }

    public function editPi($id)
    {
        $this->piId = $id;
        $this->isEditing = true;
        $this->showForm = true;
        $this->dispatch('editPi', piId: $id);
    }

    public function deletePi($id)
    {
        // Find the PI
        $pi = PrincipalInvestigator::findOrFail($id);
        $pi->user->delete();
        $pi->delete();
        $this->resetPage();

        session()->flash('success', 'Principal Investigator successfully deleted.');
    }
    public function viewPi($id)
    {
        $this->viewPiDetails = PrincipalInvestigator::findOrFail($id);

        if ($this->viewPiDetails) {
            $this->viewPiDetailView = true;

        }
    }
    public function handleHideViewPi()
    {
        $this->viewPiDetailView = false;
    }

    public function viewPiStudents($id)
    {

         $this->selectedPi = PrincipalInvestigator::findOrFail($id);
         $this->studentList = Student::where('principal_investigator_id', $id)->get();

         $this->showPiStudents = true;
    }

    public function hidePiStudentTable()
    {
        $this->showPiStudents = false;
        $this->selectedPi = null;
        $this->studentList = null;
    }

    public function toggleStatus($id)
    {
        // Find the PI
        $pi = PrincipalInvestigator::findOrFail($id);

        // Toggle status (0 to 1 or 1 to 0)
        $pi->status = !$pi->status;
        $pi->save();

        // Show success notification
        session()->flash('success', 'Status successfully updated.');
    }

    // This gets called when a PI is created
    public function handlePiCreated()
    {
        $this->showForm = false;
    }

    public function handlePiUpdated()
    {
        $this->showForm = false;
        $this->isEditing = false;
        $this->piId = null;
        session()->flash('success', 'Principal Investigator successfully updated.');
    }




    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function exportToExcel()
    {
        // Get the filtered query without pagination
        $query = $this->getFilteredQuery();
        return Excel::download(new PiExport($query), 'principal_investigators.xlsx');
    }

    public function exportToPdf()
    {
        // Get the filtered query without pagination
        $query = $this->getFilteredQuery();
        $piList = $query->get();

        $pdf = PDF::loadView('exports.pi-pdf', [
            'piList' => $piList
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'principal_investigators.pdf');
    }

    private function getFilteredQuery()
    {
        $query = PrincipalInvestigator::query()->latest();
        return $query;
    }

    public function render()
    {
        $query = PrincipalInvestigator::query()->latest();

        // Apply search filter if provided
        if ($this->search) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter if selected
        if ($this->status !== 'All') {
            $query->where('status', $this->status);
        }

        // Get paginated results
        $piList = $query->paginate(10);
        $this->totalPi = PrincipalInvestigator::count();
        $this->inactivePi = PrincipalInvestigator::where('status', 0)->count();
        $this->activePi = PrincipalInvestigator::where('status', 1)->count();

        return view('livewire.pi.pi-list', [
            'piList' => $piList,
            'isEditing' => $this->isEditing,
            'viewPiDetails' => $this->viewPiDetails,
        ]);
    }
}
