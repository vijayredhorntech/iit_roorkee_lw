<?php

namespace App\Livewire\Instruments;

use App\Models\Instrument;
use App\Models\InstrumentCategory;
use App\Models\InstrumentPurchaseInfo;
use App\Models\Lab;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class InstrumentForm extends Component
{
    use WithFileUploads;

    // Basic Information
    public $instrument_category;
    public $lab;
    public $name;
    public $model_number;
    public $serial_number;
    public $description;
    public $operating_status = 'working';
    public $per_hour_cost;
    public $minimum_booking_duration;
    public $maximum_booking_duration;

    // Photos and Documents
    public $photos = [];
    public $operational_manual;
    public $service_manual;
    public $video_link;

    // Purchase Information
    public $manufacturer_name;
    public $vendor_name;
    public $manufacturing_date;
    public $purchase_date;
    public $purchase_order_number;
    public $cost;
    public $funding_source;
    public $installation_date;
    public $warranty_period;
    public $next_service_date;
    public $engineer_name;
    public $engineer_email;
    public $engineer_mobile;
    public $engineer_address;

    public $isEditing = false;
    public $instrumentId = null;
    public $existingPhotos = [];
    public $existingOperationalManual;
    public $existingServiceManual;

    protected $listeners = [
        'editInstrument' => 'loadInstrumentData',
        'resetForm' => 'resetForm'
    ];

    protected function rules()
    {
        $rules = [
            'instrument_category' => 'required',
            'lab' => 'required',
            'name' => 'required|string|max:255',
            'model_number' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'description' => 'required|string',
            'operating_status' => 'required|string',
            'per_hour_cost' => 'required|integer',
            'minimum_booking_duration' => 'required|integer',
            'maximum_booking_duration' => 'required|integer',
            'manufacturer_name' => 'required|string|max:255',
            'vendor_name' => 'required|string|max:255',
            'manufacturing_date' => 'required|date',
            'purchase_date' => 'required|date',
            'purchase_order_number' => 'required|string|max:255',
            'cost' => 'required|integer',
            'funding_source' => 'required|string|max:255',
            'installation_date' => 'required|date',
            'warranty_period' => 'required|integer',
            'next_service_date' => 'required|date',
            'video_link' => 'nullable|url',
            'engineer_name' => 'required|string|max:100',
            'engineer_email' => 'required|email|max:100',
            'engineer_mobile' => 'required|string|max:15|min:10',
            'engineer_address' => 'required|string|max:100'
        ];

        if (!$this->isEditing) {
            $rules['photos.*'] = 'required|image|max:2048';
            $rules['photos'] = 'required|array|min:1';
        } else {
            $rules['photos.*'] = 'nullable|image|max:2048';
        }

        $rules['operational_manual'] = 'nullable|file|mimes:pdf|max:10240';
        $rules['service_manual'] =  'nullable|file|mimes:pdf|max:10240';

        return $rules;
    }

    public function loadInstrumentData($instrumentId)
    {
        $this->instrumentId = $instrumentId;
        $this->isEditing = true;

        $instrument = Instrument::findOrFail($instrumentId);
        $purchaseInfo = InstrumentPurchaseInfo::where('instrument_id', $instrumentId)->firstOrFail();

        // Load basic information
        $this->instrument_category = $instrument->instrument_category_id;
        $this->lab = $instrument->lab_id;
        $this->name = $instrument->name;
        $this->model_number = $instrument->model_number;
        $this->serial_number = $instrument->serial_number;
        $this->description = $instrument->description;
        $this->operating_status = $instrument->operating_status;
        $this->per_hour_cost = $instrument->per_hour_cost;
        $this->minimum_booking_duration = $instrument->minimum_booking_duration;
        $this->maximum_booking_duration = $instrument->maximum_booking_duration;
        $this->video_link = $instrument->video_link;
        $this->engineer_name = $instrument->engineer_name;
        $this->engineer_email = $instrument->engineer_email;
        $this->engineer_mobile = $instrument->engineer_mobile;
        $this->engineer_address = $instrument->engineer_address;

        // Load existing files
        $this->existingPhotos = json_decode($instrument->photos) ?? [];
        $this->existingOperationalManual = $instrument->operational_manual;
        $this->existingServiceManual = $instrument->service_manual;

        // Load purchase information
        $this->manufacturer_name = $purchaseInfo->manufacturer_name;
        $this->vendor_name = $purchaseInfo->vendor_name;
        $this->manufacturing_date = $purchaseInfo->manufacturing_date;
        $this->purchase_date = $purchaseInfo->purchase_date;
        $this->purchase_order_number = $purchaseInfo->purchase_order_number;
        $this->cost = $purchaseInfo->cost;
        $this->funding_source = $purchaseInfo->funding_source;
        $this->installation_date = $purchaseInfo->installation_date;
        $this->warranty_period = $purchaseInfo->warranty_period;
        $this->next_service_date = $purchaseInfo->next_service_date;
    }

    public function submit()
    {
        $this->validate();

        if ($this->isEditing) {
            $this->updateInstrument();
        } else {
            $this->createInstrument();
        }
    }

    protected function handleFileUploads()
    {
        $photosPaths = [];

        // Handle photos
        if ($this->photos) {
            foreach ($this->photos as $photo) {
                if (!is_string($photo)) {
                    $fileName = time() . '_' . rand(1000, 9999) . '_' . $photo->getClientOriginalName();
                    $path = $photo->storeAs('instrument_photos', $fileName, 'public');
                    $photosPaths[] = $path;
                }
            }
        }

        // Handle manuals
        $operationalManualPath = null;
        if ($this->operational_manual) {
            $fileName = time() . '_' . $this->operational_manual->getClientOriginalName();
            $operationalManualPath = $this->operational_manual->storeAs('instrument_manuals', $fileName, 'public');
        }

        $serviceManualPath = null;
        if ($this->service_manual) {
            $fileName = time() . '_' . $this->service_manual->getClientOriginalName();
            $serviceManualPath = $this->service_manual->storeAs('instrument_manuals', $fileName, 'public');
        }

        return [
            'photos' => $photosPaths,
            'operational_manual' => $operationalManualPath,
            'service_manual' => $serviceManualPath
        ];
    }

    public function createInstrument()
    {
        $files = $this->handleFileUploads();

        // Create instrument
        $instrument = new Instrument();
        $instrument->instrument_category_id = $this->instrument_category;
        $instrument->lab_id = $this->lab;
        $instrument->name = $this->name;
        $instrument->model_number = $this->model_number;
        $instrument->serial_number = $this->serial_number;
        $instrument->description = $this->description;
        $instrument->operating_status = $this->operating_status;
        $instrument->per_hour_cost = $this->per_hour_cost;
        $instrument->minimum_booking_duration = $this->minimum_booking_duration;
        $instrument->maximum_booking_duration = $this->maximum_booking_duration;
        $instrument->photos = json_encode($files['photos']);
        $instrument->operational_manual = $files['operational_manual'];
        $instrument->service_manual = $files['service_manual'];
        $instrument->video_link = $this->video_link;
        $instrument->engineer_name = $this->engineer_name;
        $instrument->engineer_email = $this->engineer_email;
        $instrument->engineer_mobile = $this->engineer_mobile;
        $instrument->engineer_address = $this->engineer_address;
        $instrument->save();

        // Create purchase info
        $purchaseInfo = new InstrumentPurchaseInfo();
        $purchaseInfo->instrument_id = $instrument->id;
        $purchaseInfo->manufacturer_name = $this->manufacturer_name;
        $purchaseInfo->vendor_name = $this->vendor_name;
        $purchaseInfo->manufacturing_date = $this->manufacturing_date;
        $purchaseInfo->purchase_date = $this->purchase_date;
        $purchaseInfo->purchase_order_number = $this->purchase_order_number;
        $purchaseInfo->cost = $this->cost;
        $purchaseInfo->funding_source = $this->funding_source;
        $purchaseInfo->installation_date = $this->installation_date;
        $purchaseInfo->warranty_period = $this->warranty_period;
        $purchaseInfo->next_service_date = $this->next_service_date;
        $purchaseInfo->save();

        $this->resetForm();
        $this->dispatch('toastSuccess', 'Instrument created successfully!');
        $this->dispatch('instrumentCreated');
    }

    public function updateInstrument()
    {
        $instrument = Instrument::findOrFail($this->instrumentId);
        $purchaseInfo = InstrumentPurchaseInfo::where('instrument_id', $this->instrumentId)->firstOrFail();

        $files = $this->handleFileUploads();

        // Update instrument
        $instrument->instrument_category_id = $this->instrument_category;
        $instrument->lab_id = $this->lab;
        $instrument->name = $this->name;
        $instrument->model_number = $this->model_number;
        $instrument->serial_number = $this->serial_number;
        $instrument->description = $this->description;
        $instrument->operating_status = $this->operating_status;
        $instrument->per_hour_cost = $this->per_hour_cost;
        $instrument->minimum_booking_duration = $this->minimum_booking_duration;
        $instrument->maximum_booking_duration = $this->maximum_booking_duration;
        $instrument->engineer_name = $this->engineer_name;
        $instrument->engineer_email = $this->engineer_email;
        $instrument->engineer_mobile = $this->engineer_mobile;
        $instrument->engineer_address = $this->engineer_address;

        // Update files only if new ones are uploaded
        if (!empty($files['photos'])) {
            $currentPhotos = json_decode($instrument->photos, true) ?? [];

            // Combine existing and new photos
            $updatedPhotos = array_merge($currentPhotos, $files['photos']);
            $instrument->photos = json_encode($updatedPhotos);
        }

        if ($files['operational_manual']) {
            if ($instrument->operational_manual && Storage::disk('public')->exists($instrument->operational_manual)) {
                Storage::disk('public')->delete($instrument->operational_manual);
            }
            $instrument->operational_manual = $files['operational_manual'];
        }

        if ($files['service_manual']) {
            if ($instrument->service_manual && Storage::disk('public')->exists($instrument->service_manual)) {
                Storage::disk('public')->delete($instrument->service_manual);
            }
            $instrument->service_manual = $files['service_manual'];
        }

        $instrument->video_link = $this->video_link;
        $instrument->save();

        // Update purchase info
        $purchaseInfo->manufacturer_name = $this->manufacturer_name;
        $purchaseInfo->vendor_name = $this->vendor_name;
        $purchaseInfo->manufacturing_date = $this->manufacturing_date;
        $purchaseInfo->purchase_date = $this->purchase_date;
        $purchaseInfo->purchase_order_number = $this->purchase_order_number;
        $purchaseInfo->cost = $this->cost;
        $purchaseInfo->funding_source = $this->funding_source;
        $purchaseInfo->installation_date = $this->installation_date;
        $purchaseInfo->warranty_period = $this->warranty_period;
        $purchaseInfo->next_service_date = $this->next_service_date;
        $purchaseInfo->save();

        $this->resetForm();
        $this->dispatch('toastSuccess', 'Instrument updated successfully!');

        $this->dispatch('instrumentUpdated');
    }

    public function resetForm()
    {
        $this->reset([
            'instrument_category', 'lab', 'name', 'model_number', 'serial_number',
            'description', 'operating_status', 'per_hour_cost', 'minimum_booking_duration',
            'maximum_booking_duration', 'photos', 'operational_manual', 'service_manual',
            'video_link', 'manufacturer_name', 'vendor_name', 'manufacturing_date',
            'purchase_date', 'purchase_order_number', 'cost', 'funding_source',
            'installation_date', 'warranty_period', 'next_service_date', 'isEditing',
            'instrumentId', 'existingPhotos', 'existingOperationalManual', 'existingServiceManual',
            'engineer_name', 'engineer_email', 'engineer_mobile', 'engineer_address'
        ]);

        $this->operating_status = 'working';
    }

    public function render()
    {
        $instrumentCategories = InstrumentCategory::all();
        $labs = Lab::all();
        return view('livewire.instruments.instrument-form', [
            'instrumentCategories' => $instrumentCategories,
            'labs' => $labs
        ]);
    }
}
