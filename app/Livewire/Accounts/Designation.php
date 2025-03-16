<?php

namespace App\Livewire\Accounts;

use App\Models\Designation as DesignationModel;
use Livewire\Component;

class Designation extends Component
{
    public $showDesignationModal = false;
    public $title = '';
    public $designationId = null;
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|string|max:255'
    ];

    public function showDesignationModel()
    {
        $this->resetForm();
        $this->showDesignationModal = true;
    }

    public function editDesignation($id)
    {
        $designation = DesignationModel::findOrFail($id);
        $this->designationId = $designation->id;
        $this->title = $designation->title;
        $this->isEditing = true;
        $this->showDesignationModal = true;
    }

    public function deleteDesignation($id)
    {
        DesignationModel::findOrFail($id)->delete();
        session()->flash('success', 'Designation deleted successfully!');
    }

    public function saveDesignation()
    {
        $this->validate();

        if ($this->isEditing) {
            $designation = DesignationModel::findOrFail($this->designationId);
            $designation->update(['title' => $this->title]);
            session()->flash('success', 'Designation updated successfully!');
        } else {
            DesignationModel::create(['title' => $this->title]);
            session()->flash('success', 'Designation added successfully!');
        }

        $this->resetForm();
        $this->showDesignationModal = false;
    }

    public function resetForm()
    {
        $this->reset(['title', 'designationId', 'isEditing']);
        $this->resetValidation();
    }

    public function render()
    {
        $designations = DesignationModel::all();
        return view('livewire.accounts.designation')
            ->with('designations', $designations);
    }
}
