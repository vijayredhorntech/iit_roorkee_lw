<div>

    <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300">
        <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between flex-wrap">
            <span class="font-semibold text-primary text-xl">Bookings List</span>
            <button wire:click="showForm" class="text-sm bg-primary/20 text-primary px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 hover:text-white hover:bg-primary hover:border-primary/30 transition ease-in duration-2000">
                <i class="fa fa-plus mr-2"></i>Create New Booking
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

                    @if(!$studentView)
                    <select wire:model.live="studentSearch" required
                            class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{$student->first_name}}">{{$student->first_name}} {{$student->last_name}}</option>
                        @endforeach
                    </select>
                    @endif

                    <select wire:model.live="instrumentSearch" required
                            class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="">Select Instrument</option>
                        @foreach($instruments as $instrument)
                            <option value="{{$instrument->name}}">{{$instrument->name}}</option>
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
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Instrument</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Date/ Slot</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Action</td>
                </tr>

                @forelse ($bookings as $booking)
                    <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm w-[300px]">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/' . $booking->student->profile_photo) }}"
                                     alt="{{ $booking->student->first_name }}" class="h-12 w-12 object-cover rounded-full"/>
                                <div class="w-max">
                                    <span class=" text-md text-center">{{$booking->student->first_name}} {{$booking->student->last_name}}</span> <br>
                                    <span class="mt-1 text-xs">{{ $booking->student->academic_id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$booking->instrument->name}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm w-[300px]">
                           <div class="w-max">
                               <span><i class="fa fa-calendar-days mr-1 text-success"></i> {{$booking->date}}</span> <br>
                               <span><i class="fa fa-clock mr-1 text-danger"></i> {{$booking->slot->start_time}} - {{$booking->slot->end_time}}</span>
                           </div>
                        </td>

                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm w-[300px]">
                               <div class="w-max" style="max-width: 300px">
                                    <span> @if($booking->status == 'confirmed')
                                            <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Confirmed</span>
                                        @else
                                            <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Cancelled</span>
                                        @endif</span>
                                   <br>
                                   <span> <i class="fa-regular text-{{$booking->status == 'confirmed'?'success':'danger'}} fa-comment mr-2"></i>{{$booking->description??'--'}}</span>
                               </div>
                        </td>

                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <div class="flex gap-2">
{{--                                <button wire:click="viewStudent({{ $student->id }})" title="View Details" class="bg-primary/20 text-primary h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-primary hover:text-white cursor-pointer transition ease-in duration-2000">--}}
{{--                                    <i class="fa fa-eye text-xs"></i>--}}
{{--                                </button>--}}
{{--                                <button wire:click="editStudent({{ $student->id }})" title="Edit" class="bg-warning/20 text-warning h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-warning hover:text-white cursor-pointer transition ease-in duration-2000">--}}
{{--                                    <i class="fa fa-pen text-xs"></i>--}}
{{--                                </button>--}}
                                @if($booking->status === 'confirmed')
                                    <button wire:click="cancelBooking({{ $booking->id }})" title="Cancel Booking" class="bg-danger/20 text-danger h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                        <i class="fa fa-times text-xs"></i>
                                    </button>
                                    <button wire:click="raiseComplaint({{ $booking->id }})" title="Raise Issue" class="bg-warning/20 text-warning h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-warning hover:text-white cursor-pointer transition ease-in duration-2000">
                                        <i class="fa fa-exclamation-triangle text-xs"></i>
                                    </button>
                                @endif
                            </div>
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

    @if($showCancelModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4 text-danger">Cancel Booking</h3>
                <div class="w-full flex flex-col gap-1 xl:col-span-2">
                    <label class="font-semibold text-primary">Cancellation Remark <span class="text-danger">*</span></label>
                    <textarea wire:model="cancellationRemark" rows="2" placeholder="Enter cancellation remark" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                    @error('cancellationRemark') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end space-x-3 mt-4">
                    <button
                        wire:click="$set('showCancelModal', false)"
                        class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000"
                    >
                        Back
                    </button>
                    <button type="submit"  wire:click="confirmCancellation" class="text-sm bg-danger/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-danger/90 text-ternary hover:text-white hover:bg-danger hover:border-danger/30 transition ease-in duration-2000">
                        <span wire:loading.remove wire:target="submit">
                             Confirm Cancellation
                        </span>
                        <span wire:loading wire:target="submit">
                           Cancelling booking  <i class="fas fa-hourglass-half fa-spin ml-2"></i>
            </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if($showComplaintModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4 text-danger">Raise Issue</h3>
                <form wire:submit="submitComplaint">
                    <div class="w-full flex flex-col gap-4">
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Subject <span class="text-danger">*</span></label>
                            <input type="text" wire:model="complaintSubject" placeholder="Enter issue subject" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            @error('complaintSubject') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Description <span class="text-danger">*</span></label>
                            <textarea wire:model="complaintDescription" rows="3" placeholder="Enter issue description" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                            @error('complaintDescription') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Image</label>
                            <input type="file" wire:model="complaintImage" accept="image/*" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            <div wire:loading wire:target="complaintImage" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading file... Please wait</div>
                            @error('complaintImage') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" wire:click="$set('showComplaintModal', false)" class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">Back</button>
                        <button type="submit" class="text-sm bg-danger/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-danger/90 text-ternary hover:text-white hover:bg-danger hover:border-danger/30 transition ease-in duration-2000">
                            <span wire:loading.remove wire:target="submitComplaint">Submit Issue</span>
                            <span wire:loading wire:target="submitComplaint">Submitting... <i class="fas fa-hourglass-half fa-spin ml-2"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
