<?php

namespace App\Livewire\Instruments;

use App\Models\Booking;
use Livewire\Component;

class InstrumentView extends Component
{
    public $instrument;
    public $showBookingDetailsTable = false;

    protected $listeners = [
        'hideForm' => 'handleInstrumentBookingTable',
    ];

    public function handleInstrumentBookingTable()
    {
        $this->showBookingDetailsTable = !$this->showBookingDetailsTable;
    }

    public function hideViewInstrument()
    {
        $this->dispatch('hideViewInstrument');
    }

    public function showForm()
    {
        $this->showBookingDetailsTable = !$this->showBookingDetailsTable;
    }

    public function render()
    {
        $bookings = Booking::where('instrument_id', $this->instrument->id)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.instruments.instrument-view', [
            'bookings' => $bookings
        ]);
    }
}
