<form wire:submit.prevent="submit" enctype="multipart/form-data" wire:loading.class="opacity-50">
    <div class="w-full grid xl:grid-cols-4 gap-2 p-4">
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Principle Investigator <span class="text-danger">*</span></label>
            <select wire:model="principal_investigator_id" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                @foreach($principleInvestigators as $principleInvestigator)
                    <option value="{{$principleInvestigator->id}}">{{$principleInvestigator->first_name}} {{$principleInvestigator->last_name}}</option>
                @endforeach
            </select>
            @error('department') <span class="text-red-500"> <i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Academic ID <span class="text-danger">*</span></label>
            <input type="text" wire:model="academic_id" {{$isEditing?'disabled':''}} placeholder="Enter academic ID" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('academic_id') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">First Name <span class="text-danger">*</span></label>
            <input type="text" wire:model="first_name" placeholder="Enter first name" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('first_name') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Last Name <span class="text-danger">*</span></label>
            <input type="text" wire:model="last_name" placeholder="Enter last name" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('last_name') <span class="text-red-500"> <i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Department <span class="text-danger">*</span></label>
            <select wire:model="department" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                <option value="Chemistry">Chemistry</option>
                <option value="Physics">Physics</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Biology">Biology</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Engineering">Engineering</option>
                <option value="Medicine">Medicine</option>
            </select>
            @error('department') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Email <span class="text-danger">*</span></label>
            <input type="email" wire:model="email" {{$isEditing?'disabled':''}} placeholder="Enter email address" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('email') <span class="text-red-500"> <i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Alternate Email <span class="text-danger">*</span></label>
            <input type="email" wire:model="alt_email"  placeholder="Enter alternate email address" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('alt_email') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Mobile Number <span class="text-danger">*</span></label>
            <input type="tel" wire:model="mobile_number" placeholder="Enter mobile number" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('mobile_number') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>
        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Year of Study <span class="text-danger">*</span></label>
            <select wire:model="year_of_study" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                <option value="1st">1st Year</option>
                <option value="2nd">2nd Year</option>
                <option value="3rd">3rd Year</option>
            </select>
            @error('year_of_study') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="font-semibold text-primary">Research Area <span class="text-danger">*</span></label>
            <input type="text" wire:model="research_area" placeholder="Research area" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
            @error('research_area') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>

        <div class="w-full flex flex-col gap-1 xl:col-span-2">
            <label class="font-semibold text-primary">Address <span class="text-danger">*</span></label>
            <textarea wire:model="address" rows="2" placeholder="Enter address" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
            @error('address') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
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
            @error('profile_photo') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="w-full flex justify-end px-4 pb-4 gap-2">
        <button type="submit" class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">
            <span wire:loading.remove wire:target="submit"> <i class="fa fa-{{$isEditing ? 'check' : 'plus'}} mr-2"></i>
                {{$isEditing ? 'Update Student' : 'Create Student'}}
            </span>
            <span wire:loading wire:target="submit">
                {{$isEditing ? 'Updating Student...' : 'Creating Student...'}}   <i class="fas fa-hourglass-half fa-spin ml-2"></i>
            </span>
        </button>
    </div>
</form>
