
<form wire:submit.prevent="submit" enctype="multipart/form-data" wire:loading.class="opacity-50">
    <div class="w-full grid xl:grid-cols-4 gap-2 p-4">


        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Title (Dr./Prof./etc.) <span class="text-danger">*</span></label>
            <select wire:model="title" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                <option value="">--- Select title ---</option>
                 @forelse(App\Models\Title::all() as $title)
                    <option value="{{$title->title}}">{{$title->title}}</option>
                @empty
                @endforelse
            </select>
            @error('title') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">First Name <span class="text-danger">*</span></label>
            <input type="text" wire:model="first_name" placeholder="Enter first name" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('first_name') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Last Name <span class="text-danger">*</span></label>
            <input type="text" wire:model="last_name" placeholder="Enter last name" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('last_name') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Department <span class="text-danger">*</span></label>
            <select wire:model="department" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                <option value="">--- Select department ---</option>
                @forelse(App\Models\Department::all() as $department)
                    <option value="{{$department->title}}">{{$department->title}}</option>
                @empty
                @endforelse
            </select>
            @error('department') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Designation/Position <span class="text-danger">*</span></label>
            <select wire:model="designation" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                <option value="">--- Select designation ---</option>
                @forelse(App\Models\Designation::all() as $designation)
                    <option value="{{$designation->title}}">{{$designation->title}}</option>
                @empty
                @endforelse
            </select>
            @error('designation') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Email (institutional) <span class="text-danger">*</span></label>
            <input type="email" wire:model="email" {{$isEditing?'disabled':''}} placeholder="Enter institutional email" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('email') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Alternative Email</label>
            <input type="email" wire:model="alt_email" placeholder="Enter alternative email" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('alt_email') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Phone Number <span class="text-danger">*</span></label>
            <input type="number" wire:model="phone" maxlength="15" oninput="if(this.value.length > 15) this.value=this.value.slice(0,15)" placeholder="Enter phone number" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('phone') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Mobile Number</label>
            <input type="number" wire:model="mobile" maxlength="15" oninput="if(this.value.length > 15) this.value=this.value.slice(0,15)" placeholder="Enter mobile number" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('mobile') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Specialization/Research Area <span class="text-danger">*</span></label>
            <input type="text" wire:model="specialization" placeholder="Enter specialization" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('specialization') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Academic Qualifications <span class="text-danger">*</span></label>
            <select wire:model="qualification" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                <option value="">--- Select qualification ---</option>
                @forelse(App\Models\Qualification::all() as $qualification)
                    <option value="{{$qualification->title}}">{{$qualification->title}}</option>
                @empty
                @endforelse
            </select>
            @error('qualification') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Office Address <span class="text-danger">*</span></label>
            <textarea wire:model="office_address" rows="1" placeholder="Enter office address" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
            @error('office_address') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Profile Photo <span class="text-danger">*</span></label>
            @if($isEditing && $existingPhoto)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $existingPhoto) }}" alt="Current Profile Photo" class="h-16 w-16 object-cover rounded-full border-2 border-primary/40">
                </div>
            @endif
            <input type="file" wire:model="profile_photo" accept="image/*" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            <div wire:loading wire:target="profile_photo" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading file... Please wait</div>
            @error('profile_photo') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>

    </div>
    <div class="w-full flex justify-end px-4 pb-4 gap-2">
        <button type="submit" class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">
            <span wire:loading.remove wire:target="submit"> <i class="fa fa-{{$isEditing ? 'check' : 'plus'}} mr-2"></i>
                {{$isEditing ? 'Update Pi' : 'Create Pi'}}
            </span>
            <span wire:loading wire:target="submit">
                       {{$isEditing ? 'Updating Pi...' : 'Creating Pi...'}}   <i class="fas fa-hourglass-half fa-spin ml-2"></i></i>
                    </span>
        </button>
    </div>
</form>
