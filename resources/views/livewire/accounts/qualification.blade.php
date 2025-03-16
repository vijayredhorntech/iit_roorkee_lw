<div class="mt-6 w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-6">

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
    <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
        <span class="font-semibold text-primary text-xl">Qualifications</span>
        <span wire:click="showQualificationModel" class="text-sm bg-primary/80 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-white hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
            <i class="fa fa-plus mr-2"></i>Add
        </span>
    </div>

    <div class="w-full overflow-x-auto p-4">
        <table class="w-full border-[2px] border-secondary/40 border-collapse" wire:loading.class="opacity-25">
            <tr>
                <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Title</td>
                <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Action</td>
            </tr>

            @forelse($qualifications as $qualificationData)
                <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>

                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                        <span><i class="fa fa-tag mr-1 text-success"></i> {{ $qualificationData->title }}</span> <br>
                    </td>
                    <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                        <div class="flex gap-2">
                            <button wire:click="editQualification({{ $qualificationData->id }})" title="Edit Qualification"
                                    class="bg-primary/20 text-primary h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-primary hover:text-white cursor-pointer transition ease-in duration-2000">
                                <i class="fa fa-pencil text-xs"></i>
                            </button>
                            <button wire:click="deleteQualification({{ $qualificationData->id }})"
                                    wire:confirm="Are you sure you want to delete this qualification?" title="Delete"
                                    class="bg-danger/20 text-danger h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                <i class="fa fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center">No qualifications found</td>
                </tr>
            @endforelse
        </table>
    </div>

    @if($showQualificationModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-6">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4 text-primary">{{ $isEditing ? 'Edit Qualification' : 'Add New Qualification' }}</h3>
                <form wire:submit="saveQualification">
                    <div class="w-full flex flex-col gap-4">
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Title <span class="text-danger">*</span></label>
                            <input type="text" wire:model="title" placeholder="Enter title"
                                   class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            @error('title') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" wire:click="resetForm"
                                class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">Back</button>
                        <button type="submit"
                                class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/90 text-ternary hover:text-white hover:bg-primary hover:border-primary/30 transition ease-in duration-2000">
                            <span wire:loading.remove wire:target="saveQualification">{{ $isEditing ? 'Update' : 'Save' }}</span>
                            <span wire:loading wire:target="saveQualification">{{ $isEditing ? 'Updating...' : 'Saving...' }} <i class="fas fa-hourglass-half fa-spin ml-2"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
