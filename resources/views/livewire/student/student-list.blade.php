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

   @if($viewStudentDetailView)
        <livewire:student.student-view :student="$viewStudentDetails" />
    @else

            <!-- Student Form Section -->
            <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-4" @if(!$showForm) style="display: none;" @endif>
                <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
                    <span class="font-semibold text-primary text-xl">{{ $isEditing ? 'Edit Student' : 'Student Registration' }}</span>
                    <span wire:click="hideForm" class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-primary hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                    <i class="fa fa-angle-left"></i> Back
                </span>
                </div>
                <div id="formDiv" class="w-full border-b-[2px] border-b-ternary/10 shadow-lg shadow-ternary/20">
                    <livewire:student.student-form :wire:key="'student-form-'.$studentId" />
                </div>
            </div>

            <!-- Student List Section -->
            <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-6" @if($showForm) style="display: none;" @endif>
                <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
                    <span class="font-semibold text-primary text-xl">Student List</span>
                    <span wire:click="hideForm" class="text-sm bg-primary/80 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-white hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                    <i class="fa fa-user-plus mr-2"></i>Add New Student
                </span>
                </div>

                <div class="w-full overflow-x-auto p-4">
                    <div class="w-full flex justify-between gap-2 items-center">
                        <div class="flex gap-2">
                            <button title="Export to excel" wire:click="exportToExcel" class="bg-success/20 text-success h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-success hover:text-white cursor-pointer transition ease-in duration-2000">
                                <i class="fa fa-file-excel"></i>
                            </button>
                            <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                <i class="fa fa-file-pdf"></i>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model.live.debounce.1000ms="search" placeholder="Search students..." class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                            <select wire:model.live="status" class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                                <option value="All">All</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <table class="w-full border-[2px] border-secondary/40 border-collapse mt-4" wire:loading.class="opacity-25">
                        <tr>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Profile</td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Contact</td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">PI/ Lab</td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Department</td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Bookings</td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                            <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Actions</td>
                        </tr>

                        @forelse($studentList as $student)
                            <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset('storage/' . $student->profile_photo) }}"
                                             alt="{{ $student->first_name }}" class="h-12 w-12 object-cover rounded-full"/>
                                        <div>
                                            <span class=" text-md">{{$student->first_name}} {{$student->last_name}}</span> <br>
                                            <span class="mt-1 text-xs">{{ $student->academic_id }}</span>
                                        </div>
                                    </div>

                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <span><i class="fa fa-envelope mr-1 text-success"></i> {{ $student->email }}</span> <br>
                                    <span><i class="fa fa-phone mr-1 text-danger"></i> {{ $student->mobile_number }}</span>
                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <span><i class="fa fa-user mr-1 text-primary"></i> {{ $student->principalInvestigator->getFullNameAttribute() }}</span> <br>
                                    <span><i class="fa-solid fa-flask mr-1 text-success"></i> {{ $student->principalInvestigator->labs?->lab_name }}</span>
                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <span><i class="fa fa-building mr-1 text-success"></i> {{ $student->department }}</span> <br>
                                    <span><i class="fa-solid fa-calendar-days mr-1 text-danger"></i> {{ $student->year_of_study }} Year</span>
                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                  <span> <i class="fa fa-calendar-check mr-1 text-success"></i> <span class="font-bold">
                                      {{ $student->confirmedBookings->count() }}
                                    </span></span> /  <i class="fa fa-calendar-xmark mr-1 text-danger"></i> <span class="font-bold">
                                        {{ $student->cancelledBookings->count() }}

                                    </span>
                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <button wire:click="toggleStatus({{ $student->id }})" class="focus:outline-none">
                                        @if($student->status == '0')
                                            <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Inactive</span>
                                        @else
                                            <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Active</span>
                                        @endif
                                    </button>
                                </td>
                                <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <div class="flex gap-2">
                                        <button wire:click="viewStudent({{ $student->id }})" title="View Details" class="bg-primary/20 text-primary h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-primary hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-eye text-xs"></i>
                                        </button>
                                        <button wire:click="editStudent({{ $student->id }})" title="Edit" class="bg-warning/20 text-warning h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-warning hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-pen text-xs"></i>
                                        </button>
                                        <button wire:click="deleteStudent({{ $student->id }})" wire:confirm="Are you sure you want to delete this student?" title="Delete" class="bg-danger/20 text-danger h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                            <i class="fa fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center">No students found</td>
                            </tr>
                        @endforelse
                    </table>

                    <div class="mt-4">
                        {{ $studentList->links() }}
                    </div>
                </div>
            </div>
    @endif
</div>
