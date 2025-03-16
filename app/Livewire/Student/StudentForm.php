<?php

namespace App\Livewire\Student;

use App\Mail\WelcomePrincipalInvestigatorMail;
use App\Models\PrincipalInvestigator;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentForm extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $academic_id;
    public $department;
    public $year_of_study;
    public $email;
    public $alt_email;
    public $mobile_number;
    public $research_area;
    public $address;
    public $principal_investigator_id;
    public $profile_photo;
    public $existingPhoto;

    public $isEditing = false;
    public $studentId = null;

    protected $listeners = [
        'editStudent' => 'loadStudentData',
        'resetForm' => 'resetForm'
    ];

    protected function rules()
    {
        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'academic_id' => 'required|string|max:50',
            'department' => 'required|string',
            'year_of_study' => 'required|string',
            'alt_email' => 'nullable|email|max:100',
            'mobile_number' => 'required|string|max:20',
            'research_area' => 'required|string|max:255',
            'address' => 'required|string',
            'principal_investigator_id' => 'required|exists:principal_investigators,id'
        ];

        if (!$this->isEditing) {
            $rules['profile_photo'] = 'required|image|max:1024';
            $rules['email'] = 'required|email|max:100|unique:users,email';
        } elseif ($this->profile_photo) {
            $rules['profile_photo'] = 'image|max:1024';
        }

        return $rules;
    }

    public function loadStudentData($studentId)
    {
        $this->isEditing = true;
        $this->studentId = $studentId;

        $student = Student::findOrFail($studentId);

        $this->first_name = $student->first_name;
        $this->last_name = $student->last_name;
        $this->academic_id = $student->academic_id;
        $this->department = $student->department;
        $this->year_of_study = $student->year_of_study;
        $this->email = $student->email;
        $this->alt_email = $student->alt_email;
        $this->mobile_number = $student->mobile_number;
        $this->research_area = $student->research_area;
        $this->address = $student->address;
        $this->principal_investigator_id = $student->principal_investigator_id;
        $this->existingPhoto = $student->profile_photo;
    }

    public function resetForm()
    {
        $this->reset([
            'first_name', 'last_name', 'academic_id', 'department', 'year_of_study',
            'email', 'alt_email', 'mobile_number', 'research_area', 'address',
            'principal_investigator_id', 'isEditing', 'studentId', 'profile_photo', 'existingPhoto'
        ]);
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        if ($this->isEditing) {
            $this->updateStudent();
        } else {
            $this->createStudent();
        }
    }

    private function createStudent()
    {
        $password = Str::random(10);

        $user = User::create([
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($password),
        ]);
        if ($user) {
            $user->assignRole('student');
        }

        $studentData = [
            'user_id' => $user->id,
            'principal_investigator_id' => $this->principal_investigator_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'academic_id' => $this->academic_id,
            'department' => $this->department,
            'year_of_study' => $this->year_of_study,
            'email' => $this->email,
            'alt_email' => $this->alt_email,
            'mobile_number' => $this->mobile_number,
            'research_area' => $this->research_area,
            'address' => $this->address,
        ];

        if ($this->profile_photo) {
            $fileName = time() . '_' . $this->profile_photo->getClientOriginalName();
            $filePath = $this->profile_photo->storeAs('profile_photos', $fileName, 'public');
            $studentData['profile_photo'] = $filePath;
        }

        Student::create($studentData);
        Mail::to($user->email)->send(new WelcomePrincipalInvestigatorMail($user, $password));

        $this->resetForm();
        session()->flash('success', 'Student created successfully!');
        $this->dispatch('studentCreated');
    }

    private function updateStudent()
    {
        $student = Student::findOrFail($this->studentId);

        $photoPath = $this->existingPhoto;

        if ($this->profile_photo) {
            if ($student->profile_photo && Storage::disk('public')->exists($student->profile_photo)) {
                Storage::disk('public')->delete($student->profile_photo);
            }
            $photoPath = $this->profile_photo->store('profile_photos', 'public');
        }

        $student->user->update([
            'name' => $this->first_name . ' ' . $this->last_name,
        ]);

        $student->update([
            'principal_investigator_id' => $this->principal_investigator_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'department' => $this->department,
            'year_of_study' => $this->year_of_study,
            'mobile_number' => $this->mobile_number,
            'research_area' => $this->research_area,
            'address' => $this->address,
            'profile_photo' => $photoPath
        ]);

        $this->resetForm();
        session()->flash('success', 'Student updated successfully!');
        $this->dispatch('studentUpdated');
    }

    public function render()
    {
        // check if user role is super_admin then get all principal investigators else get only the principal investigator assigned to the user
        $principleInvestigators = auth()->user()->hasRole('super_admin') ? PrincipalInvestigator::all() : PrincipalInvestigator::where('user_id', auth()->id())->get();

        return view('livewire.student.student-form')->with('principleInvestigators', $principleInvestigators);
    }
}
