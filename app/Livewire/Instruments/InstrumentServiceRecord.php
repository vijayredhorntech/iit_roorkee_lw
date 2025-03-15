<?php

namespace App\Livewire\Instruments;

use App\Models\Instrument;
use App\Models\InstrumentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class InstrumentServiceRecord extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $instrumentSearch = '';
    public $serviceType = '';
    public $status = 'pending';
    public $showCompleteModal = false;
    public $selectedService;
    public $description;
    public $cost;
    public $nextServiceDate = null;
    public $photos = [];
    public $serviceId;
    public $forSingleInstrument = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingInstrumentSearch()
    {
        $this->resetPage();
    }

    public function updatingServiceType()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function markServiceDone($id)
    {
        $this->serviceId = $id;
        $this->selectedService = InstrumentService::find($id);
        $this->description = $this->selectedService->description;
        $this->cost = $this->selectedService->cost;
        $this->nextServiceDate = $this->selectedService->next_service_date;
        $this->serviceType = $this->selectedService->service_type;
        $this->showCompleteModal = true;
    }

    public function completeService()
    {
        $this->validate([
            'serviceType' => 'required|in:repair,maintenance',
            'description' => 'required',
            'cost' => 'required|numeric',
            'photos.*' => 'image|max:1024'
        ]);

        $photosPaths = [];
        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                $photosPaths[] = $photo->store('service-photos', 'public');
            }
        }

        $service = InstrumentService::find($this->serviceId);
        $service->update([
            'service_type' => $this->serviceType,
            'description' => $this->description,
            'cost' => $this->cost,
            'next_service_date' => $this->nextServiceDate,
            'photos' => !empty($photosPaths) ? json_encode($photosPaths) : $service->photos,
            'status' => 'completed'
        ]);

        $instrument = Instrument::find($service->instrument_id);
        $instrument->update([
            'operating_status' => 'working'
        ]);

        $this->showCompleteModal = false;
        $this->reset(['description', 'cost', 'nextServiceDate', 'photos', 'serviceId', 'serviceType']);
        session()->flash('message', 'Service marked as completed successfully.');
    }

    public function exportToPdf()
    {
        $services = InstrumentService::query()
            ->when($this->forSingleInstrument && $this->instrument, function($query) {
                $query->where('instrument_id', $this->instrument->id);
            })
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                      ->orWhere('service_type', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!$this->forSingleInstrument && $this->instrumentSearch, function($query) {
                $query->whereHas('instrument', function($q) {
                    $q->where('name', 'like', '%' . $this->instrumentSearch . '%');
                });
            })
            ->when($this->serviceType, function($query) {
                $query->where('service_type', $this->serviceType);
            })
            ->when($this->status !== 'All', function($query) {
                $query->where('status', $this->status);
            })
            ->with('instrument')
            ->get();

        $pdf = Pdf::loadView('exports.service-pdf', [
            'services' => $services
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'services.pdf');
    }

    public $instrument;

    public function render()
    {
        $services = InstrumentService::query()
            ->when($this->forSingleInstrument && $this->instrument, function($query) {
                $query->where('instrument_id', $this->instrument->id);
            })
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                      ->orWhere('service_type', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!$this->forSingleInstrument && $this->instrumentSearch, function($query) {
                $query->whereHas('instrument', function($q) {
                    $q->where('name', 'like', '%' . $this->instrumentSearch . '%');
                });
            })
            ->when($this->serviceType, function($query) {
                $query->where('service_type', $this->serviceType);
            })
            ->when($this->status !== 'All', function($query) {
                $query->where('status', $this->status);
            })
            ->with('instrument')
            ->paginate(10);

        $instruments = $this->forSingleInstrument ? collect([$this->instrument]) : Instrument::all();

        return view('livewire.instruments.instrument-service-record', [
            'services' => $services,
            'instruments' => $instruments
        ]);
    }
}
