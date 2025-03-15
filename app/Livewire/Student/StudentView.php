<?php

namespace App\Livewire\Student;

use Livewire\Component;

class StudentView extends Component
{
    public $student;

    public function hideViewStudent()
    {
        $this->dispatch('hideViewStudent');
    }

    public function render()
    {
        return view('livewire.student.student-view');
    }
}