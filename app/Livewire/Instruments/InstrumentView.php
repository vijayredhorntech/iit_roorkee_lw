<?php

namespace App\Livewire\Instruments;

use App\Models\Booking;
use Livewire\Component;

class InstrumentView extends Component
{
    public $instrument;
    public $showBookingDetailsTable = false;
    public $showServicesTable = false;

    protected $listeners = [
        'hideForm' => 'handleInstrumentBookingTable',
        'hideServiceRecords' => 'toggleServiceRecords',
    ];

    public function handleInstrumentBookingTable()
    {
        $this->showBookingDetailsTable = !$this->showBookingDetailsTable;
    }

    public function showServiceTable()
    {
        $this->showServicesTable = !$this->showServicesTable;
    }

    public function hideViewInstrument()
    {
        $this->dispatch('hideViewInstrument');
    }

    public function showForm()
    {
        $this->showBookingDetailsTable = !$this->showBookingDetailsTable;
    }

    public function toggleServiceRecords()
    {
        $this->showServiceRecords = !$this->showServiceRecords;
        $this->dispatch('serviceRecordsToggled', $this->showServiceRecords);
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
