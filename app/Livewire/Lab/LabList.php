<?php

namespace App\Livewire\Lab;

use App\Exports\PiExport;
use App\Models\Lab;
use App\Models\PrincipalInvestigator;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class LabList extends Component
{
    use WithPagination;

    public $showForm = false;
    public $search = '';
    public $status = 'All';
    public $totalLab = 0;
    public $activeLab = 0;
    public $inactiveLab = 0;
    public $isEditing = false;
    public $labId = null;

    // Event listener for the form submission
    protected $listeners = [
        'labCreated' => 'handleLabCreated',
        'labUpdated' => 'handleLabUpdated',
    ];

    public function hideForm()
    {
        $this->showForm = !$this->showForm;

        if (!$this->showForm) {
            $this->isEditing = false;
            $this->labId = null;
            $this->dispatch('resetForm');
        }
    }

    public function editLab($id)
    {
        $this->labId = $id;
        $this->isEditing = true;
        $this->showForm = true;
        $this->dispatch('editLab', labId: $id);
    }

    public function deleteLab($id)
    {
        // Find the Lab
        $lab = Lab::findOrFail($id);

        if ($lab->instruments->count() > 0) {
            session()->flash('error', 'Cannot delete Lab. It has associated instruments.');
            return;
        }

        // If no instruments found, proceed with deletion
        $lab->delete();
        session()->flash('success', 'Lab successfully deleted.');
    }

    public function handleLabCreated()
    {
        $this->showForm = false;
    }

    public function handleLabUpdated()
    {
        $this->showForm = false;
        $this->isEditing = false;
        $this->labId = null;
        session()->flash('success', 'Lab updated successfully.');
    }

    public function toggleStatus($id)
    {
        // Find the Lab
        $lab = Lab::findOrFail($id);

        // Toggle status (0 to 1 or 1 to 0)
        $lab->status = !$lab->status;
        $lab->save();

        // Show success notification
        session()->flash('success', 'Status successfully updated.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }



    public function exportToPdf()
    {
        // Get the filtered query without pagination
        $query = $this->getFilteredQuery();
        $labList = $query->get();

        $pdf = PDF::loadView('exports.lab-pdf', [
            'labList' => $labList
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'labs.pdf');
    }

    private function getFilteredQuery()
    {
        $query = Lab::query()->latest();
        return $query;
    }



    public function render()
    {
        $query = Lab::query()->latest();
        // Apply search filter if provided
        if ($this->search) {
            $query->where(function($q) {
                $q->where('lab_name', 'like', '%' . $this->search . '%')
                    ->orWhere('department', 'like', '%' . $this->search . '%')
                    ->orWhere('building', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_number', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter if selected
        if ($this->status !== 'All') {
            $query->where('status', $this->status);
        }
        $labs = $query->paginate(10);
        return view('livewire.lab.lab-list')-> with('labs', $labs)->with('isEditing', $this->isEditing);
    }
}
