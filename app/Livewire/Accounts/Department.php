<?php

namespace App\Livewire\Accounts;

use App\Models\Department as DepartmentModel;
use Livewire\Component;

class Department extends Component
{
    public $showDepartmentModal = false;
    public $title = '';
    public $departmentId = null;
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|string|max:255'
    ];

    public function showDepartmentModel()
    {
        $this->resetForm();
        $this->showDepartmentModal = true;
    }

    public function editDepartment($id)
    {
        $department = DepartmentModel::findOrFail($id);
        $this->departmentId = $department->id;
        $this->title = $department->title;
        $this->isEditing = true;
        $this->showDepartmentModal = true;
    }

    public function deleteDepartment($id)
    {
        DepartmentModel::findOrFail($id)->delete();
        session()->flash('success', 'Department deleted successfully!');
    }

    public function saveDepartment()
    {
        $this->validate();

        if ($this->isEditing) {
            $department = DepartmentModel::findOrFail($this->departmentId);
            $department->update(['title' => $this->title]);
            session()->flash('success', 'Department updated successfully!');
        } else {
            DepartmentModel::create(['title' => $this->title]);
            session()->flash('success', 'Department added successfully!');
        }

        $this->resetForm();
        $this->showDepartmentModal = false;
    }

    public function resetForm()
    {
        $this->reset(['title', 'departmentId', 'isEditing']);
        $this->resetValidation();
    }

    public function render()
    {
        $departments = DepartmentModel::all();
        return view('livewire.accounts.department')
            ->with('departments', $departments);
    }
}
