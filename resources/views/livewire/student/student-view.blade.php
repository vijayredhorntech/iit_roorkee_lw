<div wire:clock >
   <div wire:loading.class="opacity-25">
       <div class="w-full grid xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-4">
           <!-- Main Info Card -->
           <div class="xl:col-span-2 lg:col-span-2 w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col">
               <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between gap-4 items-center ">
                   <span class="font-semibold text-primary text-xl">{{$student->first_name}} {{$student->last_name}} Profile</span>
                   <span wire:click="hideViewStudent"
                         class="text-sm bg-primary/30 px-2 py-0.5 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[px] border-primary/80 text-primary hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                 <i class="fa fa-xmark"></i>
                </span>
               </div>
               <div class="p-4 grid xl:grid-cols-3 gap-4">
                   <!-- Profile Photo -->
                   <div class="flex flex-col items-center gap-3">
                       <img src="{{asset('storage/'. $student->profile_photo)}}" alt="Student Photo" class="w-48 h-48 rounded-full object-cover border-4 border-primary/20">
                       <h2 class="text-xl font-semibold text-primary text-center">{{$student->first_name}} {{$student->last_name}}</h2>
                       <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium">Student</span>
                   </div>

                   <!-- Basic Info -->
                   <div class="xl:col-span-2 flex flex-col gap-2">
                       <h3 class="font-semibold text-primary">Basic Information</h3>
                       <div class="grid grid-cols-2 gap-2 text-sm">
                           <span class="text-gray-600">Academic ID:</span>
                           <span class="font-medium">{{$student->academic_id}}</span>
                           <span class="text-gray-600">Department:</span>
                           <span class="font-medium">{{$student->department}}</span>
                           <span class="text-gray-600">Email:</span>
                           <span class="font-medium">{{$student->email}}</span>
                           <span class="text-gray-600">Phone:</span>
                           <span class="font-medium">{{$student->mobile_number}}</span>
                           <span class="text-gray-600">Year of Study:</span>
                           <span class="font-medium">{{$student->year_of_study}} Year</span>
                           <span class="text-gray-600">PI:</span>
                           <span class="font-medium">{{$student->principalInvestigator->getFullNameAttribute()}}</span>
                       </div>
                   </div>

                   <!-- Research Information -->
                   <div class="xl:col-span-3 flex flex-col gap-2">
                       <h3 class="font-semibold text-primary">Research Information</h3>
                       <div class="grid xl:grid-cols-2 gap-4 text-sm">
                           <div class="flex flex-col gap-2">
                               <div class="flex flex-wrap gap-2">
                                   <span class="px-2 py-1 bg-secondary/10 text-secondary rounded-full text-xs">{{$student->research_area}}</span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

           <!-- Stats Card -->
           <div class="w-full border-[1px] border-t-[4px] border-warning/20 border-t-warning bg-white flex gap-2 flex-col">
               <div class="bg-warning/10 px-4 py-2 border-b-[2px] border-b-warning/20">
                   <span class="font-semibold text-warning text-lg">Recent Activities</span>
               </div>
               <div class="p-4">
                   <div class="relative overflow-x-auto overflow-y-auto h-[500px]">
                       <table class="w-full border-[2px] border-secondary/40 border-collapse">
                           <tr>
                               <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Date</td>
                               <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Activity</td>
                           </tr>
                           <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                               <td class="border-[2px] border-secondary/40 px-4 py-2 text-ternary/80 font-medium text-sm">{{\Carbon\Carbon::parse($student->created_at)->format('d M, Y')}}</td>
                               <td class="border-[2px] border-secondary/40 px-4 py-2 text-ternary/80 font-medium text-sm">Account Created</td>
                           </tr>
                       </table>
                   </div>
               </div>
           </div>
       </div>

       <!-- Recent Bookings Section -->
       <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col mt-4 mb-4 ">
           <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20">
               <span class="font-semibold text-primary text-lg">Recent Bookings</span>
           </div>
           <div class="p-4">
               <div class="relative overflow-x-auto">
                   <table class="w-full border-[2px] border-secondary/40 border-collapse mt-4">
                       <tr>
                           <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                           <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Date</td>
                           <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Instrument</td>
                           <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Duration</td>
                           <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                           <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Cost</td>
                       </tr>
                       <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                           <td class="border-[2px] border-secondary/40 px-4 py-1 text-ternary/80 font-medium text-sm text-center" colspan="6">No data found</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
