<div>
        @if($viewPiDetailView)
           <livewire:pi.pi-view :pi="$viewPiDetails"/>
        @else
        <div>
            <div class="w-full grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 grid-cols-1 gap-2">

                <!-- Total PIs -->
                <div
                    class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-primary bg-white flex gap-2 items-center justify-between p-4">
                    <div class="flex flex-col gap-2">
                        <span class="font-semibold text-ternary/70 text-md">Total PI</span>
                        <span class="font-bold text-2xl text-ternary">{{$totalPi}}</span>
                    </div>
                    <div>
                        <i class="fa fa-users text-4xl text-primary"></i>
                    </div>
                </div>

                <!-- Active PIs -->
                <div
                    class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-success bg-white flex gap-2 items-center justify-between p-4">
                    <div class="flex flex-col gap-2">
                        <span class="font-semibold text-ternary/70 text-md">Active PI</span>
                        <span class="font-bold text-2xl text-ternary">{{$activePi}}</span>
                    </div>
                    <div>
                        <i class="fa fa-user-check text-4xl text-success"></i>
                    </div>
                </div>

                <!-- Inactive PIs -->
                <div
                    class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-warning bg-white flex gap-2 items-center justify-between p-4">
                    <div class="flex flex-col gap-2">
                        <span class="font-semibold text-ternary/70 text-md">Inactive PI</span>
                        <span class="font-bold text-2xl text-ternary">{{$inactivePi}}</span>
                    </div>
                    <div>
                        <i class="fa fa-user-clock text-4xl text-warning"></i>
                    </div>
                </div>

                <!-- Departments -->
                <div
                    class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-secondary bg-white flex gap-2 items-center justify-between p-4">
                    <div class="flex flex-col gap-2">
                        <span class="font-semibold text-ternary/70 text-md">Departments</span>
                        <span class="font-bold text-2xl text-ternary">6</span>
                    </div>
                    <div>
                        <i class="fa fa-building-user text-4xl text-secondary"></i>
                    </div>
                </div>
            </div>
            <div wire:show="showForm"
                 class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-4"
                 @if(!$showForm) style="display: none;" @endif>

                <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
            <span
                class="font-semibold text-primary text-xl">{{ $isEditing ? 'Edit Principal Investigator (PI)' : 'Principal Investigator (PI) Registration' }}</span>
                    <span wire:click="hideForm"
                          class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-primary hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                 <i class="fa fa-angle-left"></i>
                Back</span>

                </div>
                <div id="formDiv" class="w-full border-b-[2px] border-b-ternary/10 shadow-lg shadow-ternary/20">
                    <livewire:pi.pi-form/>
                </div>
            </div>
            <div wire:show="!showForm"
                 class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-6">
                <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
                    <span class="font-semibold text-primary text-xl">Principal Investigators List</span>
                    <span wire:click="hideForm"
                          class="text-sm bg-primary/80 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-white hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                <i class="fa fa-user-plus mr-2"></i>
                Create New PI</span>

                </div>
                <div class="w-full overflow-x-auto p-4">
                    <div class="w-full flex justify-between gap-2 items-center">
                        <div class="flex gap-2">
                            <button title="Export to excel" wire:click="exportToExcel"
                                    class="bg-success/20 text-success h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-success hover:text-white cursor-pointer transition ease-in duration-2000">
                                <i class="fa fa-file-excel"></i>
                            </button>

                            <button title="Export to pdf" wire:click="exportToPdf"
                                    class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                <i class="fa fa-file-pdf"></i>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model.live.debounce.1000ms="search" name="search" required
                                   placeholder="Search PI"
                                   class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                            <select wire:model.live="status" required
                                    class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                <option value="All">All</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <table class="w-full border-[2px] border-secondary/40 border-collapse mt-4" wire:loading.class="opacity-25">
                        <tr>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Sr. No.
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Photo
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Name
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Email
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Phone
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Designation
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Department
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Status
                            </td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">
                                Action
                            </td>
                        </tr>

                        @forelse ($piList as $pi)
                            <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <img src="{{ asset('storage/' . $pi->profile_photo) }}"
                                         alt="{{ $pi->getFullNameAttribute() }}" class="h-8 w-8 object-cover rounded-full"/>
                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$pi->getFullNameAttribute()}}</td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$pi->email}}</td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$pi->phone}}</td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$pi->designation}}</td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$pi->department}}</td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <button wire:click="toggleStatus({{ $pi->id }})" class="focus:outline-none">
                                        @if($pi->status == '0')
                                            <span
                                                class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Inactive</span>
                                        @else
                                            <span
                                                class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Active</span>
                                        @endif
                                    </button>
                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <div class="flex gap-2">
                                        <button wire:click="viewPi({{ $pi->id }})" title="View Details"
                                                class="bg-primary/20 text-primary h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-primary hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-eye text-xs"></i>
                                        </button>
                                        <button wire:click="editPi({{ $pi->id }})" title="Edit"
                                                class="bg-warning/20 text-warning h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-warning hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-pen text-xs"></i>
                                        </button>
                                        <button wire:click="deletePi({{ $pi->id }})"
                                                wire:confirm="Are you sure you want to delete this PI?" title="Delete"
                                                class="bg-danger/20 text-danger h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center"
                                    colspan="9">No PI found
                                </td>
                            </tr>
                        @endforelse

                    </table>
                    <div class="mt-4">
                        {{ $piList->links() }}
                    </div>
                </div>
            </div>
        </div>
       @endif
</div>
