<?php

namespace App\Livewire\Lab;

use App\Models\Lab;
use App\Models\PrincipalInvestigator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class LabForm extends Component
{
    use WithFileUploads;

    // Form Fields
    public $lab_image;
    public $lab_name;
    public $department;
    public $building;
    public $floor;
    public $room_number;
    public $type;
    public $manager;
    public $contact_number;
    public $working_hours;
    public $capacity;
    public $description;
    public $safety_guidelines;
    public $notes;
    public $status = 1;

    public $isEditing = false;
    public $labId = null;
    public $existingPhoto = null;

    protected $listeners = [
        'editLab' => 'loadLabData',
        'resetForm' => 'resetForm'
    ];

    protected function rules()
    {
        $rules = [
            'lab_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'floor' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'manager' => 'required',
            'contact_number' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'description' => 'required|string',
            'safety_guidelines' => 'required|string',
            'notes' => 'nullable|string',
        ];

        // Only require image for new labs, make it optional for editing
        if (!$this->isEditing) {
            $rules['lab_image'] = 'required|image|max:2048';
        } else {
            $rules['lab_image'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    public function loadLabData($labId)
    {
        $this->labId = $labId;
        $this->isEditing = true;
        $lab = Lab::findOrFail($labId);

        $this->lab_name = $lab->lab_name;
        $this->department = $lab->department;
        $this->building = $lab->building;
        $this->floor = $lab->floor;
        $this->room_number = $lab->room_number;
        $this->type = $lab->type;
        $this->manager = $lab->principal_investigator_id;
        $this->contact_number = $lab->contact_number;
        $this->working_hours = $lab->working_hours;
        $this->capacity = $lab->capacity;
        $this->description = $lab->description;
        $this->safety_guidelines = $lab->safety_guidelines;
        $this->notes = $lab->notes;
        $this->status = $lab->status;
        $this->existingPhoto = $lab->lab_image;
    }

    public function submit()
    {
        // Validate form data
        $this->validate();

        if ($this->isEditing) {
            $this->updateLab();
        } else {
            $this->createLab();
        }
    }

    public function createLab()
    {
        $filePath = null;
        if ($this->lab_image) {
            $fileName = time() . '_' . $this->lab_image->getClientOriginalName();
            $filePath = $this->lab_image->storeAs('lab_images', $fileName, 'public');
        }

        $lab = new Lab();
        $lab->lab_name = $this->lab_name;
        $lab->department = $this->department;
        $lab->building = $this->building;
        $lab->floor = $this->floor;
        $lab->room_number = $this->room_number;
        $lab->type = $this->type;
        $lab->principal_investigator_id = $this->manager;
        $lab->contact_number = $this->contact_number;
        $lab->working_hours = $this->working_hours;
        $lab->capacity = $this->capacity;
        $lab->description = $this->description;
        $lab->safety_guidelines = $this->safety_guidelines;
        $lab->notes = $this->notes;
        $lab->status = $this->status;
        $lab->lab_image = $filePath;
        $lab->save();

        $this->resetForm();
        session()->flash('success', 'Lab created successfully!');

        $this->dispatch('labCreated');
    }

    public function updateLab()
    {
        $lab = Lab::findOrFail($this->labId);

        // Update image if a new one was uploaded
        if ($this->lab_image) {
            // Delete old image if it exists
            if ($lab->lab_image && Storage::disk('public')->exists($lab->lab_image)) {
                Storage::disk('public')->delete($lab->lab_image);
            }

            // Store new image
            $fileName = time() . '_' . $this->lab_image->getClientOriginalName();
            $filePath = $this->lab_image->storeAs('lab_images', $fileName, 'public');
            $lab->lab_image = $filePath;
        }

        $lab->lab_name = $this->lab_name;
        $lab->department = $this->department;
        $lab->building = $this->building;
        $lab->floor = $this->floor;
        $lab->room_number = $this->room_number;
        $lab->type = $this->type;
        $lab->principal_investigator_id = $this->manager;
        $lab->contact_number = $this->contact_number;
        $lab->working_hours = $this->working_hours;
        $lab->capacity = $this->capacity;
        $lab->description = $this->description;
        $lab->safety_guidelines = $this->safety_guidelines;
        $lab->notes = $this->notes;
        $lab->save();

        $this->resetForm();
        session()->flash('success', 'Lab updated successfully!');

        $this->dispatch('labUpdated');
    }

    public function resetForm()
    {
        $this->reset([
            'lab_image',
            'lab_name',
            'department',
            'building',
            'floor',
            'room_number',
            'type',
            'manager',
            'contact_number',
            'working_hours',
            'capacity',
            'description',
            'safety_guidelines',
            'notes',
            'isEditing',
            'labId',
            'existingPhoto'
        ]);

        // Reset status to default (1)
        $this->status = 1;
    }

    public function render()
    {
        $principleInvestigators = PrincipalInvestigator::all();
        return view('livewire.lab.lab-form', [
            'principleInvestigators' => $principleInvestigators
        ]);
    }
}
