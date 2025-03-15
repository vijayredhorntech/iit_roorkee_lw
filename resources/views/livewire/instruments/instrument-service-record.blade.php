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
    <div class="w-full {{$forSingleInstrument?'':'border-[1px] border-t-[4px] border-primary/20 border-t-primary'}}  bg-white flex gap-2 flex-col shadow-lg shadow-gray-300">
        @if(!$forSingleInstrument)
        <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
            <span class="font-semibold text-primary text-xl">Instrument Service Records</span>
        </div>
        @endif
        <div class="w-full overflow-x-auto p-4">
            <div class="w-full flex justify-between gap-2 items-center mb-4">
                <div class="flex gap-2">
                    <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                        <i class="fa fa-file-pdf"></i>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <input type="text" wire:model.live.debounce.1000ms="search" name="search" required placeholder="Search Services"
                           class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>

                    @if(!$forSingleInstrument)
                    <select wire:model.live="instrumentSearch" required
                            class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="">Select Instrument</option>
                        @foreach($instruments as $instrument)
                            <option value="{{$instrument->name}}">{{$instrument->name}}</option>
                        @endforeach
                    </select>
                    @endif

                    <select wire:model.live="serviceType" required
                            class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="">Select Service Type</option>
                        <option value="repair">Repair</option>
                        <option value="maintenance">Maintenance</option>
                    </select>

                    <select wire:model.live="status" required
                            class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="All">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>

            <table class="w-full border-[2px] border-secondary/40 border-collapse" wire:loading.class="opacity-25">
                <tr>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Instrument</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Service Type</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Description</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Cost</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Next Service Date</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Photos</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Action</td>
                </tr>

                @forelse ($services as $service)
                    <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span><i class="fa-solid fa-flask mr-1 text-success"></i> {{$service->instrument->name}}</span> <br>
                            <span class="text-xs"><i class="fa fa-clock mr-1 text-danger"></i> {{ $service->created_at->format('d/M/Y h:i A') }}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            @if($service->service_type == 'repair')
                                <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Repair</span>
                            @else
                                <span class="bg-warning/20 text-warning px-2 py-0.5 rounded-full text-xs">Maintenance</span>
                            @endif
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm w-[200px]">
                            <span class="text-md">{{$service->description}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span class="text-md">₹{{$service->cost ?? '-'}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span class="text-md">{{$service->next_service_date ?? '-'}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            @if($service->photos)
                                @foreach(json_decode($service->photos) as $photo)
                                    <a href="{{asset('storage/'.$photo)}}" target="_blank" class="inline-block">
                                        <img src="{{asset('storage/'.$photo)}}" class="h-12 w-auto mb-1" alt="Service Photo">
                                    </a>
                                @endforeach
                            @else
                                <span class="text-md">No Photos Available</span>
                            @endif
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            @if($service->status == 'pending')
                                <span class="bg-warning/20 text-warning px-2 py-0.5 rounded-full text-xs">Pending</span>
                            @else
                                <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Completed</span>
                            @endif
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <div class="flex gap-2">
                                @if($service->status == 'pending')
                                    <button wire:click="markServiceDone({{ $service->id }})" title="Mark as done" class="bg-success/20 text-success h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-success hover:text-white cursor-pointer transition ease-in duration-2000">
                                        <i class="fa fa-check text-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center" colspan="9">No service records found</td>
                    </tr>
                @endforelse
            </table>

            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </div>

    @if($showCompleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4 text-success">Complete Service</h3>
                <form wire:submit="completeService">
                    <div class="w-full flex flex-col gap-4">
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Service Type <span class="text-danger">*</span></label>
                            <select wire:model="serviceType" required class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                <option value="">Select Service Type</option>
                                <option value="repair">Repair</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                            @error('serviceType') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Description <span class="text-danger">*</span></label>
                            <textarea wire:model="description" rows="3" placeholder="Enter service description" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                            @error('description') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Cost (₹)<span class="text-danger">*</span></label>
                            <input type="number" wire:model="cost" placeholder="Enter service cost" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            @error('cost') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Next Service Date</label>
                            <input type="date" wire:model="nextServiceDate" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            @error('nextServiceDate') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Photos</label>
                            <input type="file" wire:model="photos" multiple accept="image/*" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            <div wire:loading wire:target="photos" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading files... Please wait</div>
                            @error('photos.*') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" wire:click="$set('showCompleteModal', false)" class="text-sm bg-danger/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-danger/90 text-ternary hover:text-white hover:bg-danger hover:border-danger/30 transition ease-in duration-2000">Cancel</button>
                        <button type="submit" class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-success/30 transition ease-in duration-2000">
                            <span wire:loading.remove wire:target="completeService">Complete Service</span>
                            <span wire:loading wire:target="completeService">Completing... <i class="fas fa-hourglass-half fa-spin ml-2"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
