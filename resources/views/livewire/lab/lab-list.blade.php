<div>

    <div wire:show="showForm" @if(!$showForm) style="display: none;" @endif class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300">

        <div  class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
            <span class="font-semibold text-primary text-xl">{{ $isEditing ? 'Edit Lab' : 'Lab Registration' }}</span>
            <span
                class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-primary hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer"><i
                    class="fa fa-angle-left mr-2"></i>Back</span>

        </div>

        <div id="formDiv" class="w-full border-b-[2px] border-b-ternary/10 shadow-lg shadow-ternary/20" >
            <livewire:lab.lab-form />
        </div>
    </div>

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
    <div wire:show="!showForm" class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-6">
        <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
            <span class="font-semibold text-primary text-xl">Lab List</span>
            <span wire:click="hideForm" class="text-sm bg-primary/80 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-white hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                <i class="fa fa-user-plus mr-2"></i>
                Create New Lab</span>

        </div>
        <div class="w-full overflow-x-auto p-4">
            <div class="w-full flex justify-between gap-2 items-center">
                <div class="flex gap-2">


                    <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                        <i class="fa fa-file-pdf"></i>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <input type="text" wire:model.live.debounce.1000ms="search" name="search" required placeholder="Search PI" class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                    <select wire:model.live="status" required class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="All">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <table class="w-full border-[2px] border-secondary/40 border-collapse mt-4" wire:loading.class="opacity-25">
                <tr>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Lab</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">In Charge</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Type/ Department</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Location</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Instruments</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Action</td>
                </tr>

                @forelse ($labs as $lab)
                    <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/' . $lab->lab_image) }}"
                                     alt="{{ $lab->lab_name }}" class="h-12 w-12 object-cover rounded-full"/>
                                <div>
                                    <span class=" text-md">{{$lab->lab_name}}</span> <br>
                                </div>
                            </div>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span><i class="fa fa-user mr-1 text-success"></i> {{$lab->principalInvestigator->first_name}}</span> <br>
                            <span><i class="fa fa-phone mr-1 text-danger"></i> {{$lab->contact_number}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span><i class="fa fa-tag mr-1 text-success"></i> {{$lab->type}}</span> <br>
                                <span><i class="fa fa-building mr-1 text-danger"></i> {{$lab->department}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span>{{$lab->room_number}}/  {{$lab->floor}}</span> <br>
                            <span> {{$lab->building}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <span class="cursor-pointer group"><i class="fa-solid fa-flask mr-1 text-success group-hover:text-danger transition ease-in duration-2000"></i>
                                <span class="text-md font-bold">{{ $lab->instruments->count() }}</span>
                            </span> <br>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <button wire:click="toggleStatus({{ $lab->id }})" class="focus:outline-none">
                                @if($lab->status == '0')
                                    <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Inactive</span>
                                @else
                                    <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Active</span>
                                @endif
                            </button>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            <div class="flex gap-2">

                                <button wire:click="editLab({{ $lab->id }})" title="Edit" class="bg-warning/20 text-warning h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-warning hover:text-white cursor-pointer transition ease-in duration-2000">
                                    <i class="fa fa-pen text-xs"></i>
                                </button>
                                <button wire:click="deleteLab({{ $lab->id }})" wire:confirm="Are you sure you want to delete this PI?" title="Delete" class="bg-danger/20 text-danger h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                    <i class="fa fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center" colspan="9">No PI found</td>
                    </tr>
                @endforelse

            </table>
            <div class="mt-4">
                {{ $labs->links() }}
            </div>
        </div>
    </div>



</div>
