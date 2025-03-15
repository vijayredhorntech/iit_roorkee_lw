<?php

namespace App\Livewire\Instruments;

use App\Models\Instrument;
use App\Models\InstrumentAccessorie;
use App\Models\InstrumentPurchaseInfo;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class InstrumentList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showForm = false;
    public $search = '';
    public $status = 'All';
    public $isEditing = false;
    public $instrumentId = null;
    public $viewInstrumentDetailView = false;
    public $viewInstrumentDetails;

    // Accessory Modal Properties
    public $showAccessoryModal = false;
    public $selectedInstrument = null;
    public $accessoryName = '';
    public $accessoryModelNumber = '';
    public $accessoryPurchaseDate = '';
    public $accessoryPrice = '';
    public $accessoryDescription = '';
    public $accessoryStatus = 'available';
    public $accessoryPhoto = null;

    // Event listener for the form submission
    protected $listeners = [
        'instrumentCreated' => 'handleInstrumentCreated',
        'instrumentUpdated' => 'handleInstrumentUpdated',
        'hideViewInstrument' => 'handleHideViewInstrument',
    ];

    public function hideForm()
    {
        $this->showForm = !$this->showForm;

        if (!$this->showForm) {
            $this->isEditing = false;
            $this->instrumentId = null;
            $this->dispatch('resetForm');
        }
    }

    public function editInstrument($id)
    {
        $this->instrumentId = $id;
        $this->isEditing = true;
        $this->showForm = true;
        $this->dispatch('editInstrument', instrumentId: $id);
    }

    public function viewInstrument($id)
    {
        $this->viewInstrumentDetails = Instrument::findOrFail($id);

        if ($this->viewInstrumentDetails) {
            $this->viewInstrumentDetailView = true;
        }
    }

    public function handleHideViewInstrument()
    {
        $this->viewInstrumentDetailView = false;
    }

    public function deleteInstrument($id)
    {
        // Find the Instrument and its purchase info
        $instrument = Instrument::findOrFail($id);
        $purchaseInfo = InstrumentPurchaseInfo::where('instrument_id', $id)->first();

        // Delete files
        if ($instrument->photos) {
            foreach (json_decode($instrument->photos) as $photo) {
                if (Storage::disk('public')->exists($photo)) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        if ($instrument->operational_manual && Storage::disk('public')->exists($instrument->operational_manual)) {
            Storage::disk('public')->delete($instrument->operational_manual);
        }

        if ($instrument->service_manual && Storage::disk('public')->exists($instrument->service_manual)) {
            Storage::disk('public')->delete($instrument->service_manual);
        }

        // Delete purchase info and instrument
        if ($purchaseInfo) {
            $purchaseInfo->delete();
        }
        $instrument->delete();

        session()->flash('success', 'Instrument successfully deleted.');
    }

    public function handleInstrumentCreated()
    {
        $this->showForm = false;
    }

    public function handleInstrumentUpdated()
    {
        $this->showForm = false;
        $this->isEditing = false;
        $this->instrumentId = null;
        session()->flash('success', 'Instrument updated successfully.');
    }

    public function toggleStatus($id)
    {
        // Find the Instrument
        $instrument = Instrument::findOrFail($id);

        // Toggle status between 'working' and 'under_maintenance'
        $instrument->operating_status = $instrument->operating_status === 'working' ? 'under_maintenance' : 'working';
        $instrument->save();

        session()->flash('success', 'Status successfully updated.');
    }

    public function addAccessories($id)
    {
        $this->selectedInstrument = Instrument::findOrFail($id);
        $this->showAccessoryModal = true;
    }

    public function submitAccessory()
    {
        $this->validate([
            'accessoryName' => 'required|min:3',
            'accessoryModelNumber' => 'required',
            'accessoryPurchaseDate' => 'required|date',
            'accessoryPrice' => 'required|numeric',
            'accessoryDescription' => 'required|min:10',
            'accessoryStatus' => 'required|in:available,notAvailable',
            'accessoryPhoto' => 'required|image|max:1024',
        ]);

        $photoPath = $this->accessoryPhoto->store('accessory-photos', 'public');

        InstrumentAccessorie::create([
            'instrument_id' => $this->selectedInstrument->id,
            'name' => $this->accessoryName,
            'model_number' => $this->accessoryModelNumber,
            'purchase_date' => $this->accessoryPurchaseDate,
            'price' => $this->accessoryPrice,
            'description' => $this->accessoryDescription,
            'status' => $this->accessoryStatus,
            'photo' => $photoPath,
        ]);

        $this->showAccessoryModal = false;
        $this->selectedInstrument = null;
        $this->resetAccessoryFields();

        $this->dispatch('toastSuccess', 'Accessory has been added successfully.');
    }

    private function resetAccessoryFields()
    {
        $this->accessoryName = '';
        $this->accessoryModelNumber = '';
        $this->accessoryPurchaseDate = '';
        $this->accessoryPrice = '';
        $this->accessoryDescription = '';
        $this->accessoryStatus = 'available';
        $this->accessoryPhoto = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function exportToPdf()
    {
        $query = $this->getFilteredQuery();
        $instruments = $query->get();

        $pdf = PDF::loadView('exports.instrument-pdf', [
            'instruments' => $instruments
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'instruments.pdf');
    }

    private function getFilteredQuery()
    {
        $query = Instrument::with(['instrumentCategory', 'lab'])->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('model_number', 'like', '%' . $this->search . '%')
                    ->orWhere('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('operating_status', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'All') {
            $query->where('operating_status', $this->status);
        }

        return $query;
    }

    public function render()
    {
        $query = $this->getFilteredQuery();
        $instruments = $query->paginate(10);

        return view('livewire.instruments.instrument-list', [
            'instruments' => $instruments,
            'isEditing' => $this->isEditing,
            'viewInstrumentDetails' => $this->viewInstrumentDetails,
        ]);
    }
}
