<div>
    @if($viewInstrumentDetailView)
        <livewire:instruments.instrument-view :instrument="$viewInstrumentDetails"/>
    @else
        <div wire:show="showForm" @if(!$showForm) style="display: none;" @endif class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300">
            <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
                <span class="font-semibold text-primary text-xl">{{ $isEditing ? 'Edit Instrument' : 'Instrument Registration' }}</span>
                <span wire:click="hideForm" class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-primary hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer"><i class="fa fa-angle-left mr-2"></i>Back</span>
            </div>
            <div id="formDiv" class="w-full border-b-[2px] border-b-ternary/10 shadow-lg shadow-ternary/20">
                <livewire:instruments.instrument-form />
            </div>
        </div>
        <div wire:show="!showForm" class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-6">
            <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
                <span class="font-semibold text-primary text-xl">Instrument List</span>
                @can ('create instrument')
                    <span wire:click="hideForm" class="text-sm bg-primary/80 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-white hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                <i class="fa fa-plus mr-2"></i>
                Create New Instrument</span>
                @endcan
            </div>
            <div class="w-full overflow-x-auto p-4">
                <div class="w-full flex justify-between gap-2 items-center">
                    <div class="flex gap-2">
                        <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                            <i class="fa fa-file-pdf"></i>
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model.live.debounce.1000ms="search" name="search" required placeholder="Search Instrument" class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                        <select wire:model.live="status" required class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            <option value="All">All</option>
                            <option value="working">Working</option>
                            <option value="under_maintenance">Under Maintenance</option>
                            <option value="calibration_required">Calibration Required</option>
                            <option value="faulty">Faulty</option>
                            <option value="retired">Retired/Obsolete</option>
                        </select>
                    </div>
                </div>
                <table class="w-full border-[2px] border-secondary/40 border-collapse mt-4" wire:loading.class="opacity-25">
                    <tr>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Instrument</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Lab</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Service Engineer</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Bookings</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Next Booking/ Slot</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Accessories</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                        @can ('create instrument')
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Action</td>
                        @endcan
                    </tr>

                    @forelse ($instruments as $instrument)
                        <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <div class="flex items-center gap-2">
                                    @if($instrument->photos)
                                        @php $photos = json_decode($instrument->photos); @endphp
                                        @if(count($photos) > 0)
                                            <img src="{{ asset('storage/' . $photos[0]) }}" alt="{{ $instrument->name }}" class="h-12 w-12 object-cover rounded-full"/>
                                        @endif
                                    @endif
                                    <div>
                                        <span class=" text-md">{{$instrument->name}}</span> <br>
                                        <span class="mt-1 text-xs">{{$instrument->instrumentCategory->title??''}}</span>
                                    </div>
                                </div>

                            </td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <span><i class="fa fa-vial mr-1 text-success"></i> {{$instrument->lab->lab_name}}</span> <br>
                                <span class="text-xs"><i class="fa fa-qrcode mr-1 text-danger"></i> {{$instrument->model_number}}</span>
                            </td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <span><i class="fa fa-user mr-1 text-success"></i> {{$instrument->engineer_name}}</span> <br>
                                <span class="text-xs"><i class="fa fa-phone mr-1 text-danger"></i> {{$instrument->engineer_mobile}}</span>
                            </td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <span><i class="fa fa-ticket mr-1 text-success"></i> {{$instrument->bookings?->count()}}</span> <br>
                                <span class="text-xs"><i class="fa fa-tag mr-1 text-danger"></i> {{$instrument->per_hour_cost}} ₹</span><br>
                            </td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <span><i class="fa fa-calendar-check mr-1 text-danger"></i> {{$instrument->getNextBookingDateTime()}}</span> <br>
                                <span class="text-xs"><i class="fa fa-calendar-day mr-1 text-success"></i>  {{$instrument->getNextAvailableSlot()}}</span>
                            </td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <div class="flex items-center gap-2">
                                    {{$instrument->instrumentAccessories->count()}}
                                    <button wire:click="addAccessories({{ $instrument->id }})" title="Add Accessory" class="bg-success/20 text-success h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-success hover:text-white cursor-pointer transition ease-in duration-2000">
                                        <i class="fa fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <button wire:click="toggleStatus({{ $instrument->id }})" class="focus:outline-none">
                                    @if($instrument->operating_status == 'working')
                                        <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Working</span>
                                    @elseif($instrument->operating_status == 'under_maintenance')
                                        <span class="bg-warning/20 text-warning px-2 py-0.5 rounded-full text-xs">Under Maintenance</span>
                                    @elseif($instrument->operating_status == 'calibration_required')
                                        <span class="bg-info/20 text-info px-2 py-0.5 rounded-full text-xs">Calibration Required</span>
                                    @elseif($instrument->operating_status == 'faulty')
                                        <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Faulty</span>
                                    @else
                                        <span class="bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full text-xs">Retired/Obsolete</span>
                                    @endif
                                </button>
                            </td>
                            @can ('create instrument')
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <div class="flex gap-2">
                                        <button wire:click="viewInstrument({{ $instrument->id }})" title="View" class="bg-primary/20 text-primary h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-primary hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-eye text-xs"></i>
                                        </button>
                                        <button wire:click="editInstrument({{ $instrument->id }})" title="Edit" class="bg-warning/20 text-warning h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-warning hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-pen text-xs"></i>
                                        </button>
                                        {{--                                <button wire:click="deleteInstrument({{ $instrument->id }})" wire:confirm="Are you sure you want to delete this instrument?" title="Delete" class="bg-danger/20 text-danger h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">--}}
                                        {{--                                    <i class="fa fa-trash text-xs"></i>--}}
                                        {{--                                </button>--}}
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center" colspan="10">No instruments found</td>
                        </tr>
                    @endforelse
                </table>
                <div class="mt-4">
                    {{ $instruments->links() }}
                </div>
            </div>
        </div>

        @if($showAccessoryModal)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                    <h3 class="text-lg font-semibold mb-4 text-primary">Add Accessory</h3>
                    <form wire:submit="submitAccessory">
                        <div class="w-full flex flex-col gap-4">
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="accessoryName" placeholder="Enter accessory name" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                @error('accessoryName') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Model Number <span class="text-danger">*</span></label>
                                <input type="text" wire:model="accessoryModelNumber" placeholder="Enter model number" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                @error('accessoryModelNumber') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" wire:model="accessoryPurchaseDate" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                @error('accessoryPurchaseDate') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Price <span class="text-danger">*</span></label>
                                <input type="number" wire:model="accessoryPrice" placeholder="Enter price" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                @error('accessoryPrice') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Description <span class="text-danger">*</span></label>
                                <textarea wire:model="accessoryDescription" rows="3" placeholder="Enter description" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                                @error('accessoryDescription') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Status <span class="text-danger">*</span></label>
                                <select wire:model="accessoryStatus" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                    <option value="available">Available</option>
                                    <option value="notAvailable">Not Available</option>
                                </select>
                                @error('accessoryStatus') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full flex flex-col gap-1">
                                <label class="font-semibold text-primary">Photo <span class="text-danger">*</span></label>
                                <input type="file" wire:model="accessoryPhoto" accept="image/*" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                <div wire:loading wire:target="accessoryPhoto" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading file... Please wait</div>
                                @error('accessoryPhoto') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-4">
                            <button type="button" wire:click="$set('showAccessoryModal', false)" class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">Back</button>
                            <button type="submit" class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/90 text-ternary hover:text-white hover:bg-primary hover:border-primary/30 transition ease-in duration-2000">
                                <span wire:loading.remove wire:target="submitAccessory">Submit Accessory</span>
                                <span wire:loading wire:target="submitAccessory">Submitting... <i class="fas fa-hourglass-half fa-spin ml-2"></i></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @endif
    </div>
