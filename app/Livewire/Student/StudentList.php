<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;

class StudentList extends Component
{
    use WithPagination;

    public $showForm = false;
    public $search = '';
    public $status = 'All';
    public $departments = 7; // Added a default count for departments
    public $isEditing = false;
    public $studentId = null;
    public $viewStudentDetailView = false;
    public $viewStudentDetails;

    protected $listeners = [
        'studentCreated' => 'handleStudentCreated',
        'studentUpdated' => 'handleStudentUpdated',
        'hideViewStudent' => 'handleHideViewStudent',
    ];

    public function hideForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->isEditing = false;
            $this->studentId = null;
            $this->dispatch('resetForm');
        }
    }

    public function editStudent($id)
    {
        $this->isEditing = true;
        $this->showForm = true;
        $this->dispatch('editStudent', $id);
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->user->delete();
        $student->delete();
        $this->resetPage();
        session()->flash('success', 'Student successfully deleted.');
    }

    public function viewStudent($id)
    {
        $this->viewStudentDetails = Student::findOrFail($id);
        if ($this->viewStudentDetails) {
            $this->viewStudentDetailView = true;
        }
    }

    public function handleHideViewStudent()
    {
        $this->viewStudentDetailView = false;
    }

    public function toggleStatus($id)
    {
        $student = Student::findOrFail($id);
        $student->status = !$student->status;
        $student->save();
        session()->flash('success', 'Status successfully updated.');
    }

    public function handleStudentCreated()
    {
        $this->showForm = false;
    }

    public function handleStudentUpdated()
    {
        $this->showForm = false;
        $this->isEditing = false;
        $this->studentId = null;
        session()->flash('success', 'Student successfully updated.');
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
        $query = $this->getFilteredQuery();
        return Excel::download(new StudentExport($query), 'students.xlsx');
    }

    public function exportToPdf()
    {
        $query = $this->getFilteredQuery();
        $studentList = $query->get();
        $pdf = PDF::loadView('exports.student-pdf', ['studentList' => $studentList]);
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'students.pdf');
    }

    private function getFilteredQuery()
    {
        $query = Student::query()->latest();
        return $query;
    }

    public function render()
    {

//        $query = Student::query()->latest();
        if (auth()->user()->hasRole('super_admin'))
        {
            $query = Student::query()->latest();
        }
        else
        {
            $query = Student::where('principal_investigator_id', auth()->user()->principalInvestigators->first()->id)->latest();
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('academic_id', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'All') {
            $query->where('status', $this->status);
        }

        $studentList = $query->paginate(10);

        return view('livewire.student.student-list', [
            'studentList' => $studentList,
            'isEditing' => $this->isEditing,
            'viewStudentDetails' => $this->viewStudentDetails,
        ]);
    }
}
