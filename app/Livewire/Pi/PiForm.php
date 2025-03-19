<?php

namespace App\Livewire\Pi;

use App\Mail\WelcomePrincipalInvestigatorMail;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\PrincipalInvestigator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Usernotnull\Toast\Concerns\WireToast;

class PiForm extends Component
{
    use WithFileUploads;


    // Form Fields
    public $title;
    public $first_name;
    public $last_name;
    public $department;
    public $designation;
    public $email;
    public $alt_email;
    public $phone;
    public $mobile;
    public $office_address;
    public $specialization;
    public $qualification;
    public $profile_photo;
    public $status = 1;

    public $isEditing = false;
    public $piId = null;
    public $existingPhoto = null;


    protected $listeners = [
        'editPi' => 'loadPiData',
        'resetForm' => 'resetForm'
    ];


    // Validation Rules
    protected function rules()
    {
        $rules = [
            'title' => 'required',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'department' => 'required|string',
            'designation' => 'required|string',
            'alt_email' => 'nullable|email|max:100',
            'phone' => 'required|string|min:10|max:15|regex:/^\d{1,15}$/',
            'mobile' => 'nullable|string|min:10|max:15|regex:/^\d{1,15}$/',
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string',
            'office_address' => 'required|string',
        ];

        // Only require photo during creation, not during editing unless a new one is uploaded
        if (!$this->isEditing) {
            $rules['profile_photo'] = 'required|image|max:1024';
            $rules['email'] = 'required|email|max:100|unique:users,email';
        } elseif ($this->profile_photo) {
            $rules['profile_photo'] = 'image|max:1024';
        }

        return $rules;
    }

    // Custom error messages
    protected function messages()
    {
        return [
            'email.unique' => 'This email is already registered in our system.',
            'alt_email.different' => 'Alternative email must be different from primary email.',
            'profile_photo.max' => 'The profile photo must not exceed 1MB.',
        ];
    }

    public function loadPiData($piId)
    {
        $this->isEditing = true;
        $this->piId = $piId;

        $pi = PrincipalInvestigator::findOrFail($piId);

        // Populate form fields
        $this->title = $pi->title;
        $this->first_name = $pi->first_name;
        $this->last_name = $pi->last_name;
        $this->department = $pi->department;
        $this->designation = $pi->designation;
        $this->email = $pi->email;
        $this->alt_email = $pi->alt_email;
        $this->phone = $pi->phone;
        $this->mobile = $pi->mobile;
        $this->specialization = $pi->specialization;
        $this->qualification = $pi->qualification;
        $this->office_address = $pi->office_address;
        $this->existingPhoto = $pi->profile_photo;
    }

    public function resetForm()
    {
        $this->reset([
            'profile_photo', 'title', 'first_name', 'last_name', 'department',
            'designation', 'email', 'alt_email', 'phone', 'mobile',
            'specialization', 'qualification', 'office_address',
            'isEditing', 'piId', 'existingPhoto'
        ]);

        // Clear validation errors
        $this->resetValidation();
    }


    public function submit()
    {
        // Validate form data
        $this->validate();

        if ($this->isEditing) {
            $this->updatePi();
        } else {
            $this->createPi();
        }
    }

    // Submit form
    public function createPi()
    {
        $this->validate();

        $password = Str::random(10);

        $user = User::create([
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($password),
        ]);

        if ($user) {
            $user->assignRole('pi');
        }



        $piData = [
            'user_id' => $user->id,
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'department' => $this->department,
            'designation' => $this->designation,
            'email' => $this->email,
            'alt_email' => $this->alt_email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'office_address' => $this->office_address,
            'specialization' => $this->specialization,
            'qualification' => $this->qualification,
            'status' => $this->status,
        ];

        if ($this->profile_photo) {
            $fileName = time() . '_' . $this->profile_photo->getClientOriginalName();
            $filePath = $this->profile_photo->storeAs('profile_photos', $fileName, 'public');
            $piData['profile_photo'] = $filePath;
        }

        PrincipalInvestigator::create($piData);
        Mail::to($user->email)->send(new WelcomePrincipalInvestigatorMail($user, $password));
        $this->resetForm();
        session()->flash('success', 'Principal Investigator created successfully!');


        $this->dispatch('piCreated');

    }

    private function updatePi()
    {
        $pi = PrincipalInvestigator::findOrFail($this->piId);

        // Handle photo update
        $photoPath = $this->existingPhoto;

        if ($this->profile_photo) {
            // Delete old photo if exists
            if ($pi->profile_photo && Storage::disk('public')->exists($pi->profile_photo)) {
                Storage::disk('public')->delete($pi->profile_photo);
            }

            // Store new photo
            $photoPath = $this->profile_photo->store('profile_photos', 'public');
        }
        $pi->user->update([
            'name' => $this->first_name . ' ' . $this->last_name,
        ]);

        // Update the PI record
        $pi->update([
            'profile_photo' => $photoPath,
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'department' => $this->department,
            'designation' => $this->designation,
            'alt_email' => $this->alt_email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'specialization' => $this->specialization,
            'qualification' => $this->qualification,
            'office_address' => $this->office_address,
        ]);

        // Reset the form
        $this->resetForm();
        session()->flash('success', 'Principal Investigator updated successfully!');

        $this->dispatch('piUpdated');
    }


    public function render()
    {
        return view('livewire.pi.pi-form');
    }
}

