<?php

namespace App\Livewire\Accounts;

use App\Models\Qualification as QualificationModel;
use Livewire\Component;

class Qualification extends Component
{
    public $showQualificationModal = false;
    public $title = '';
    public $qualificationId = null;
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|string|max:255'
    ];

    public function showQualificationModel()
    {
        $this->resetForm();
        $this->showQualificationModal = true;
    }

    public function editQualification($id)
    {
        $qualification = QualificationModel::findOrFail($id);
        $this->qualificationId = $qualification->id;
        $this->title = $qualification->title;
        $this->isEditing = true;
        $this->showQualificationModal = true;
    }

    public function deleteQualification($id)
    {
        QualificationModel::findOrFail($id)->delete();
        session()->flash('success', 'Qualification deleted successfully!');
    }

    public function saveQualification()
    {
        $this->validate();

        if ($this->isEditing) {
            $qualification = QualificationModel::findOrFail($this->qualificationId);
            $qualification->update(['title' => $this->title]);
            session()->flash('success', 'Qualification updated successfully!');
        } else {
            QualificationModel::create(['title' => $this->title]);
            session()->flash('success', 'Qualification added successfully!');
        }

        $this->resetForm();
        $this->showQualificationModal = false;
    }

    public function resetForm()
    {
        $this->reset(['title', 'qualificationId', 'isEditing']);
        $this->resetValidation();
    }

    public function render()
    {
        $qualifications = QualificationModel::all();
        return view('livewire.accounts.qualification')
            ->with('qualifications', $qualifications);
    }
}
