<div>
    @if($showStatusModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4 text-primary">Update Complaint Status</h3>
                <form wire:submit="confirmStatusUpdate">
                    <div class="w-full flex flex-col gap-4">
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Status <span class="text-danger">*</span></label>
                            <select wire:model="complaintStatus" required class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                <option value="">Select Status</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            @error('selectedStatus') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Remarks <span class="text-danger">*</span></label>
                            <textarea wire:model="complaintRemark" required placeholder="Enter remarks" rows="3" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                            @error('remarks') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" wire:click="$set('showStatusModal', false)" class="text-sm bg-danger/20 text-danger px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-danger/90 hover:text-white hover:bg-danger hover:border-danger/30 transition ease-in duration-2000">
                                <i class="fa fa-times mr-2"></i>Cancel
                            </button>
                            <button type="submit" class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-success/30 transition ease-in duration-2000">
                                <span wire:loading.remove wire:target="confirmStatusUpdate">
                                    <i class="fa fa-check mr-2"></i>Update Status
                                </span>
                                <span wire:loading wire:target="confirmStatusUpdate">
                                    Updating Status... <i class="fas fa-hourglass-half fa-spin ml-2"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300">
        <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
            <span class="font-semibold text-primary text-xl">Instrument Complaints List</span>
        </div>
        <div class="w-full overflow-x-auto p-4">
            <div class="w-full flex justify-between gap-2 items-center mb-4">
                <div class="flex gap-2">
                    <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                        <i class="fa fa-file-pdf"></i>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <input type="text" wire:model.live.debounce.1000ms="search" name="search" required placeholder="Search Complaints"
                           class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>

                    <select wire:model.live="studentSearch" required
                            class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{$student->first_name}}">{{$student->first_name}} {{$student->last_name}}</option>
                        @endforeach
                    </select>

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
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <table class="w-full border-[2px] border-secondary/40 border-collapse" wire:loading.class="opacity-25">
                <tr>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Student Name</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Instrument</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Description</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Photo</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Remark</td>
                  @can('update instrument complaint')
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Action</td>
                  @endcan
                </tr>

                @forelse ($complaints as $complaint)
                    <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/' . $complaint->student->profile_photo) }}"
                                     alt="{{ $complaint->student->first_name }}" class="h-12 w-12 object-cover rounded-full"/>
                                <div>
                                    <span class=" text-md">{{$complaint->student->first_name}} {{$complaint->student->last_name}}</span> <br>
                                    <span class="mt-1 text-xs">{{ $complaint->student->academic_id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span><i class="fa-solid fa-flask mr-1 text-success"></i> {{$complaint->instrument->name}}</span> <br>
                            <span class="text-xs"><i class="fa fa-clock mr-1 text-danger"></i>  {{ $complaint->created_at->format('d/M/Y h:i A') }}</span>
                        </td>

                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span class=" text-md">{{$complaint->subject}}</span> <br>
                            <span class="mt-1 text-xs">{{$complaint->description}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                           @if($complaint->image)
                                <a href="{{asset('storage/'.$complaint->image)}}" target="_blank">
                                    <img src="{{asset('storage/'.$complaint->image)}}" class="h-12 w-auto " alt="{{$complaint->subject}}">
                                </a>
                               @else
                                <span class=" text-md">No Image Available</span>
                            @endif

                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            @if($complaint->status == 'pending')
                                <span class="bg-warning/20 text-warning px-2 py-0.5 rounded-full text-xs">Pending</span>
                            @elseif($complaint->status == 'approved')
                                <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Approved</span>
                            @else
                                <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Rejected</span>
                            @endif
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm w-[300px]">
                            <span class=" text-md">{{$complaint->remark??'-'}}</span> <br>
                        </td>
                        @can('update instrument complaint')
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                @if($complaint->status == 'pending')
                                <button wire:click="updateStatus({{ $complaint->id }})" title="Update status"
                                        class="bg-primary/20 text-primary h-6  px-2 flex justify-center items-center rounded-[3px] hover:bg-primary hover:text-white cursor-pointer transition ease-in duration-2000">
                                    <i class="fa fa-pencil text-xs mr-2"></i>
                                </button>
                                    @else
                                    <span class="mt-1 text-xs">Status Already Updated</span>
                                @endif
                            </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center" colspan="7">No complaints found</td>
                    </tr>
                @endforelse
            </table>

            <div class="mt-4">
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
</div>
