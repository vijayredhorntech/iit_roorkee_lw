<div >
    <form wire:submit.prevent="submit" enctype="multipart/form-data" wire:loading.class="opacity-50">

        <div class="w-full grid xl:grid-cols-4 gap-2 p-4">
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Lab Photo <span class="text-danger">*</span></label>
                @if($isEditing && $existingPhoto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $existingPhoto) }}" alt="Current Profile Photo" class="h-16 w-16 object-cover rounded-full border-2 border-primary/40">
                    </div>
                @endif
                <input type="file" wire:model="lab_image" accept="image/*" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                <div wire:loading wire:target="lab_image" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading file... Please wait</div>
                @error('profile_photo') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Lab Name <span class="text-danger">*</span></label>
                <input type="text" wire:model="lab_name" name="lab_name" placeholder="Enter lab name"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                   @error('lab_name') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Department <span class="text-danger">*</span></label>
                <select name="department" wire:model="department"
                        class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                    <option value="">--- Select department ---</option>
                    <option value="Chemistry">Chemistry</option>
                    <option value="Physics">Physics</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Biology">Biology</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Medicine">Medicine</option>
                </select>
                 @error('department') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Building/Block <span
                        class="text-danger">*</span></label>
                <input type="text" name="building" wire:model="building" placeholder="Enter building/block"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
               @error('building') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Floor <span class="text-danger">*</span></label>
                <input type="text" name="floor" wire:model="floor" placeholder="Enter floor"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                 @error('floor') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Room Number <span class="text-danger">*</span></label>
                <input type="number" name="room_number" wire:model="room_number" placeholder="Enter room number"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('room_number') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Lab Type <span class="text-danger">*</span></label>
                <select name="lab_type" wire:model="type"
                        class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                    <option value="">--- Select lab type ---</option>
                    <option value="Experimental">Experimental</option>
                    <option value="Non-experimental">Non-experimental</option>
                </select>
                @error('type') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Lab Manager (PI Reference) <span
                        class="text-danger">*</span></label>
                <select name="lab_manager" wire:model="manager"
                        class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="">--- select lab manager ---</option>
                        @forelse ($principleInvestigators as $principleInvestigator)
                            <option value="{{ $principleInvestigator->id }}">{{ $principleInvestigator->user->name }}</option>
                        @empty
                            <option value="">--- No lab manager found ---</option>
                        @endforelse
                </select>
                @error('manager') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Contact Number <span
                        class="text-danger">*</span></label>
                <input type="phone" name="contact_number" wire:model="contact_number" oninput="if(this.value.length > 15) this.value=this.value.slice(0,15)"
                       placeholder="Enter contact number"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('contact_number') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Working Hours <span
                        class="text-danger">*</span></label>
                <input type="number" name="working_hours" wire:model="working_hours"
                       placeholder="Enter working hours"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('working_hours') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Maximum Capacity <span
                        class="text-danger">*</span></label>
                <input type="number" name="max_capacity" wire:model="capacity"
                       placeholder="Enter maximum capacity"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('capacity') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1 col-span-2">
                <label class="font-semibold text-primary">Description</label>
                <textarea name="description" rows="2" wire:model="description"
                          placeholder="Enter lab description"
                          class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                 @error('description') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1 col-span-2">
                <label class="font-semibold text-primary">Safety Guidelines</label>
                <textarea name="safety_guidelines" rows="2" wire:model="safety_guidelines"
                          placeholder="Enter safety guidelines"
                          class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                @error('safety_guidelines') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1 col-span-2">
                <label class="font-semibold text-primary">Special Requirements/Notes</label>
                <textarea name="special_requirements" rows="2" wire:model="notes"
                          placeholder="Enter special requirements or notes"
                          class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                @error('notes') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
        </div>
        <div class="w-full flex justify-end px-4 pb-4 gap-2">
            <button type="submit"
                    class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">
                         <span wire:loading.remove wire:target="submit">
                             <i class="fa fa-{{$isEditing ? 'check' : 'plus'}} mr-2"></i>
                                                                 {{$isEditing ? 'Update Lab' : 'Create Lab'}}
                                </span>
                <span wire:loading wire:target="submit">
                       {{$isEditing ? 'Updating Lab...' : 'Creating Lab...'}}   <i class="fas fa-hourglass-half fa-spin ml-2"></i>
                    </span>
            </button>
        </div>
    </form>

</div>
