<?php
namespace App\Livewire\Bookings;

use App\Models\Instrument;
use App\Models\Student;
use App\Models\Slot;
use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class Create extends Component
{
    public $isEditing = false;
    public $student;
    public $instrument;
    public $date;
    public $selectedSlot;
    public $description;

    public $selectedInstrument = null;
    public $selectedDate = null;
    public $allSlots = [];
    public $bookedSlotIds = [];

    protected $listeners = [
        'showForm' => 'handleShowForm',
        'toastError' => 'showErrorToast',
        'toastSuccess' => 'showSuccessToast'

    ];

    public function showSuccessToast($message)
    {
        session()->flash('success', $message);
    }

    public function showErrorToast($message)
    {
        session()->flash('error', $message);
    }

    public function handleShowForm()
    {
        $this->isEditing = true;
    }


    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
    }


    public function hideForm()
    {
        $this->reset(['student', 'instrument', 'selectedSlot', 'selectedInstrument', 'description']);
        $this->date = Carbon::today()->format('Y-m-d');
        $this->selectedDate = null;
        $this->isEditing = false;
    }

    public function updatedInstrument($instrumentId)
    {
        $this->selectedInstrument = Instrument::find($instrumentId);
        $this->reset(['selectedSlot']); // Reset selected slot when instrument changes
        $this->selectedDate = Carbon::today()->format('Y-m-d'); // Set selected date to today
        $this->loadAllSlots();
    }

    public function updatedDate($date)
    {
        // Prevent selecting past dates
        if (Carbon::parse($date)->isBefore(Carbon::today())) {
            $this->date = Carbon::today()->format('Y-m-d');
            session()->flash('error', 'Cannot select past dates.');
            return;
        }

        if ($this->selectedInstrument) {
            $this->selectedDate = Carbon::parse($date)->format('Y-m-d');
            $this->reset('selectedSlot'); // Reset selected slot when date changes
            $this->loadAllSlots();
        }
    }

    public function selectSlot($slotId)
    {
        // Only allow selecting available slots
        if (!in_array($slotId, $this->bookedSlotIds)) {
            $this->selectedSlot = $slotId;
        }
    }

    protected function loadAllSlots()
    {
        if (!$this->selectedInstrument || !$this->date) {
            return;
        }

        // Get all slots
        $this->allSlots = Slot::orderBy('start_time')->get();

        $currentDate = Carbon::today();
        $selectedDate = Carbon::parse($this->date);
        $currentTime = Carbon::now();

        // Get booked slots and expired slots for the selected date and instrument
        $this->bookedSlotIds = Booking::where('instrument_id', $this->selectedInstrument->id)
            ->where('date', $selectedDate->format('Y-m-d'))
            ->where('status', 'confirmed')
            ->pluck('slot_id')
            ->toArray();

        // If the selected date is today, add expired slots to bookedSlotIds
        if ($selectedDate->isToday()) {
            foreach ($this->allSlots as $slot) {
                $slotEndTime = Carbon::parse($this->date . ' ' . $slot->end_time);
                if ($slotEndTime->isPast()) {
                    $this->bookedSlotIds[] = $slot->id;
                }
            }
        }

        // If selected date is in the past, mark all slots as booked
        if ($selectedDate->isBefore($currentDate)) {
            $this->bookedSlotIds = $this->allSlots->pluck('id')->toArray();
        }
    }

    public function rules()
    {
        return [
            'student' => 'required|exists:students,id',
            'instrument' => 'required|exists:instruments,id',
            'date' => 'required|date|after_or_equal:today',
            'selectedSlot' => 'required|exists:slots,id',
            'description' => 'nullable|string|max:1000'
        ];
    }

    public function submit()
    {
        $this->validate();

        // Check if slot is still available
        if (in_array($this->selectedSlot, $this->bookedSlotIds)) {
            session()->flash('error', 'This slot has already been booked. Please select another slot.');
            return;
        }

        try {
            // Create new booking
            Booking::create([
                'student_id' => $this->student,
                'instrument_id' => $this->instrument,
                'slot_id' => $this->selectedSlot,
                'date' => Carbon::parse($this->date)->format('Y-m-d'),
                'description' => $this->description,
                'status' => 'confirmed'
            ]);

            // Reset form
            $this->reset(['student', 'instrument', 'selectedSlot', 'selectedInstrument', 'description']);
            $this->date = Carbon::today()->format('Y-m-d');
            $this->selectedDate = null;
            $this->allSlots = [];
            $this->bookedSlotIds = [];

            // Show success message
            session()->flash('success', 'Booking created successfully!');
            $this->hideForm();

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while creating the booking. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.bookings.create', [
            'students' => Student::orderBy('first_name')->get(),
            'instruments' => Instrument::orderBy('name')->get(),
        ]);
    }
}
