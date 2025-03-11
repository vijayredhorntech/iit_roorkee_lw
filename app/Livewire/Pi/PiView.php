<?php

namespace App\Livewire\Pi;

use Livewire\Component;

class PiView extends Component
{


    public function hideViewPi()
    {
        $this->dispatch('hideViewPi');
    }

    public $pi;

    public function render()
    {
        return view('livewire.pi.pi-view');
    }
}
