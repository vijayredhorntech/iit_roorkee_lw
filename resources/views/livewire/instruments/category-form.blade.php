<div>
    <form wire:submit.prevent="submit" wire:loading.class="opacity-50">
        <div class="w-full grid xl:grid-cols-2 gap-2 p-4">
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Title <span class="text-danger">*</span></label>
                <input type="text" wire:model="title" name="title" placeholder="Enter category title"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('title') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Description <span class="text-danger">*</span></label>
                <textarea wire:model="description" name="description" rows="3" placeholder="Enter category description"
                          class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                @error('description') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
        </div>
        <div class="w-full flex justify-end px-4 pb-4 gap-2">
            <button type="submit"
                    class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">
                <span wire:loading.remove wire:target="submit">
                    <i class="fa fa-{{$isEditing ? 'check' : 'plus'}} mr-2"></i>
                    {{$isEditing ? 'Update Category' : 'Create Category'}}
                </span>
                <span wire:loading wire:target="submit">
                    {{$isEditing ? 'Updating Category...' : 'Creating Category...'}} <i class="fas fa-hourglass-half fa-spin ml-2"></i>
                </span>
            </button>
        </div>
    </form>
</div>
