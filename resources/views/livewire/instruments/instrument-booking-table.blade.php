<div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300">
    <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
        <span class="font-semibold text-primary text-xl">Bookings Details for <i class="text-danger">{{$instrument->name}}</i> </span>
        <button wire:click="hideForm" class="text-sm bg-danger/20 text-danger px-2 py-0.5 mr-2 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-danger/80 hover:text-white hover:bg-danger hover:border-danger/30 transition ease-in duration-2000">
            <i class="fa fa-xmark"></i>
        </button>
    </div>
    <div class="w-full overflow-x-auto p-4">
        <div class="w-full flex justify-between gap-2 items-center mb-4">
            <div class="flex gap-2">
                <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                    <i class="fa fa-file-pdf"></i>
                </button>
            </div>
            <div class="flex items-center gap-2">
                <input type="text" wire:model.live.debounce.1000ms="search" name="search" required placeholder="Search Bookings"
                       class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>

                <select wire:model.live="studentSearch" required
                        class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{$student->first_name}}">{{$student->first_name}} {{$student->last_name}}</option>
                    @endforeach
                </select>
                <select wire:model.live="status" required
                        class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                    <option value="All">All Status</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <table class="w-full border-[2px] border-secondary/40 border-collapse" wire:loading.class="opacity-25">
            <tr>
                <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Student Name</td>
                <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Date/ Slot</td>
                <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
            </tr>

            @forelse ($bookings as $booking)
                <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('storage/' . $booking->student->profile_photo) }}"
                                 alt="{{ $booking->student->first_name }}" class="h-12 w-12 object-cover rounded-full"/>
                            <div>
                                <span class=" text-md">{{$booking->student->first_name}} {{$booking->student->last_name}}</span> <br>
                                <span class="mt-1 text-xs">{{ $booking->student->academic_id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                        <span><i class="fa fa-calendar-days mr-1 text-success"></i> {{$booking->date}}</span> <br>
                        <span><i class="fa fa-clock mr-1 text-danger"></i> {{$booking->slot->start_time}} - {{$booking->slot->end_time}}</span>
                    </td>

                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm w-[600px]">
                                <span> @if($booking->status == 'confirmed')
                                        <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Confirmed</span>
                                    @else
                                        <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Cancelled</span>
                                    @endif</span>
                        <br>
                        <span> <i class="fa-regular text-{{$booking->status == 'confirmed'?'success':'danger'}} fa-comment mr-2"></i>{{$booking->description??'--'}}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center" colspan="6">No bookings found</td>
                </tr>
            @endforelse
        </table>

        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
