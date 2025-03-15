<div>
    @if (session()->has('success'))
        <div id="successMessage"
             class="absolute max-w-[600px] top-4 right-4 alert alert-success bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-2 mb-4 pr-20">
            {{ session('success') }}
            <div onclick="document.getElementById('successMessage').classList.add('hidden')"
                 class="cursor-pointer bg-green-200 py-2 px-4 h-full flex justify-center absolute top-0 right-0 items-center">
                <i class="fa fa-xmark "></i>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div id="dangerMessage"
             class="absolute max-w-[600px] top-4 right-4 alert alert-danger bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-2 mb-4 pr-20">
            {{ session('error') }}
            <div onclick="document.getElementById('dangerMessage').classList.add('hidden')"
                 class="cursor-pointer bg-red-200 py-2 px-4 h-full flex justify-center absolute top-0 right-0 items-center">
                <i class="fa fa-xmark "></i>
            </div>
        </div>
    @endif
    @if($isEditing)
        <div class="w-full border-[1px] border-t-[4px] border-danger/20 border-t-danger bg-white flex flex-col shadow-lg shadow-gray-300">
            <div class="bg-danger/10 px-4 py-2 border-b-[2px] border-b-danger/20 flex justify-between">
                <span class="font-semibold text-danger text-xl">New Booking</span>
                <button wire:click="hideForm" class="text-sm bg-danger/20 text-danger px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-danger/80 hover:text-white hover:bg-danger hover:border-danger/30 transition ease-in duration-2000">
                    <i class="fa fa-angle-left mr-2"></i>Back
                </button>
            </div>
            <div class="w-full p-4">
                <div class="w-full grid lg:grid-cols-4 gap-4">

                    <!-- Instrument Details -->
                    <div class="w-full w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex shadow-lg shadow-primary/10 flex-col">
                        <div class="bg-primary/10 px-4 py-1 border-b-[2px] border-b-primary/20 flex justify-between">
                            <span class="font-semibold text-primary text-md">Find the instrument</span>
                        </div>
                        <div class="w-full grid  gap-2 p-4 ">
                            <div class="w-full flex flex-col gap-1">

                                <label class="font-semibold text-primary">Select Student <span class="text-danger">*</span></label>
                                <select wire:model.live="student" class="px-2 py-2 w-full text-sm font-medium bg-transparent border-[2px] border-primary/40 rounded focus:border-primary">
                                    <option value="">--Select Student--</option>
                                    @foreach($students as $student)
                                        <option value="{{$student->id}}">{{$student->first_name}} {{$student->last_name}}</option>
                                    @endforeach
                                </select>
                                @error('student') <span class="text-red-500"> <i class="fa fa-exclamation-triangle mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                            <!-- Instrument Selection -->
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Select Instrument <span class="text-danger">*</span></label>
                                <select wire:model.live="instrument" class="px-2 py-2 w-full text-sm font-medium bg-transparent border-[2px] border-primary/40 rounded focus:border-primary">
                                    <option value="">--Select Instrument--</option>
                                    @foreach($instruments as $instrument)
                                        <option value="{{$instrument->id}}">{{$instrument->name}}</option>
                                    @endforeach
                                </select>
                                @error('instrument') <span class="text-red-500"> <i class="fa fa-exclamation-triangle mr-2"></i>{{ $message }}</span> @enderror
                            </div>

                            <!-- Date Selection -->
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Date <span class="text-danger">*</span></label>
                                <input
                                    type="date"
                                    wire:model.live.debounce.500ms="date"
                                    min="{{ date('Y-m-d') }}"
                                    x-data
                                    x-init="() => {
            $watch('instrument', value => {
                if(value) {
                    setTimeout(() => $el.showPicker(), 100);
                }
            })
        }"
                                    class="px-2 py-2 w-full text-sm font-medium bg-transparent border-[2px] border-primary/40 rounded focus:border-primary"
                                />
                                @error('date') <span class="text-red-500"><i class="fa fa-exclamation-triangle mr-2"></i> {{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if($selectedInstrument)
                            <div>
                                <div class="bg-primary/10 px-4 py-1 border-b-[2px] border-b-primary/20 flex justify-between">
                                    <span class="font-semibold text-primary text-md">Instrument Details</span>
                                </div>
                                <div class=" flex flex-col items-center py-4">
                                    @if($selectedInstrument->photos)
                                        @php $photos = json_decode($selectedInstrument->photos); @endphp
                                        @if(count($photos) > 0)
                                            <img src="{{ asset('storage/' . $photos[0]) }}" alt="{{ $selectedInstrument->name }}" class="h-40 w-auto object-cover rounded-[3px]"/>
                                        @endif
                                    @endif
                                    <p class="font-semibold text-lg text-danger mt-4"> {{ $selectedInstrument->name }}</p>
                                    <p class="text-black font-semibold text-sm"> <span class="text-{{
    $selectedInstrument->operating_status == 'working' ? 'success' :
    ($selectedInstrument->operating_status == 'under_maintenance' || $selectedInstrument->operating_status == 'calibration_required' ? 'warning' : 'danger')
}} bg-{{
    $selectedInstrument->operating_status == 'working' ? 'success' :
    ($selectedInstrument->operating_status == 'under_maintenance' || $selectedInstrument->operating_status == 'calibration_required' ? 'warning' : 'danger')
}}/20 border-[1px] border-{{
    $selectedInstrument->operating_status == 'working' ? 'success' :
    ($selectedInstrument->operating_status == 'under_maintenance' || $selectedInstrument->operating_status == 'calibration_required' ? 'warning' : 'danger')
}}/40 px-4 py-1 rounded-full text-sm">
    {{ ucfirst(str_replace('_', ' ', $selectedInstrument->operating_status)) }}
</span>
                                        - {{$selectedInstrument->per_hour_cost}} ₹/ hour</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Available Slots -->
                    <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex flex-col lg:col-span-3">
                        @if($selectedDate && $selectedInstrument)

                            <div class="bg-primary/10 px-4 py-1 border-b-[2px] border-b-primary/20 flex justify-between">
                                <span class="font-semibold text-primary text-md">Time Slots for {{ $selectedDate }}</span>
                            </div>

                            @if(count($allSlots) > 0)
                                <div class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-5 sm:grid-cols-3 grid-cols-2 gap-4 p-4">
                                    @foreach($allSlots as $slot)
                                        @php
                                            $isBooked = in_array($slot->id, $bookedSlotIds);
                                            $isSelected = $selectedSlot == $slot->id;
                                        @endphp
                                        <label
                                            class="border-2 p-3 rounded-lg text-center cursor-pointer transition-all duration-200
                                        {{ $isBooked ? 'bg-red-100 border-red-400 opacity-70 cursor-not-allowed' : 'hover:bg-green-50 border-green-300' }}
                                        {{ $isSelected && !$isBooked ? 'bg-green-200 border-green-500' : '' }}"
                                        >
                                            <input
                                                type="radio"
                                                name="slot"
                                                value="{{ $slot->id }}"
                                                wire:model.live="selectedSlot"
                                                {{ $isBooked ? 'disabled' : '' }}
                                                class="hidden"
                                            >
                                            <div class="font-medium mb-1">{{ date('h:i A', strtotime($slot->start_time)) }} - {{ date('h:i A', strtotime($slot->end_time)) }}</div>
                                            <div class="text-sm font-semibold {{ $isBooked ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $isBooked ? 'Booked' : 'Available' }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selectedSlot') <span class="text-red-500 block mt-2"><i class="fa fa-exclamation-triangle mr-2"></i> Please select an available time slot</span> @enderror
                            @else
                                <p class="text-gray-500">No time slots found</p>
                            @endif
                            <div class="p-4">
                                <div class="w-full flex flex-col gap-1 mt-4">
                                    <label class="font-semibold text-primary">Description <span class="text-danger">*</span></label>
                                    <textarea wire:model="description" name="description" rows="3" placeholder="Description"
                                              class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                                    @error('description') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
                                </div>
                            </div>
                        @else
                            <div class="flex justify-center items-center h-full">
                                <img class="h-40 " src="{{asset('assets/images/bookNow.png')}}" alt="">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="w-full flex justify-end px-4 pb-4 gap-2">
                <button
                    type="button"
                    wire:click="submit"
                    class="text-sm bg-success/30 px-4 py-1 rounded font-semibold border-[2px] border-success text-ternary hover:text-white hover:bg-success hover:border-ternary transition"
                    {{ !$selectedSlot ? 'disabled' : '' }}
                >
            <span wire:loading.remove wire:target="submit"> <i class="fa fa-plus mr-2"></i>
                Create Booking
            </span>
                    <span wire:loading wire:target="submit">
                Creating booking   <i class="fas fa-hourglass-half fa-spin ml-2"></i>
            </span>
                </button>
            </div>
        </div>
    @else
            <livewire:bookings.booking-list/>
    @endif
</div>
