<div>
    <form wire:submit.prevent="submit" wire:loading.class="opacity-50">
        <div class="w-full grid lg:grid-cols-4 gap-2 p-4">
            <div class="w-full lg:col-span-4 bg-primary/10 px-4 py-2 font-semibold text-primary mb-4">
                Basic Information
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Instrument Category <span class="text-danger">*</span></label>
                <select wire:model="instrument_category" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                    @foreach($instrumentCategories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select>
                @error('instrument_category') <span class="text-red-500"> <i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Lab <span class="text-danger">*</span></label>
                <select wire:model="lab" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                    @foreach($labs as $lab)
                        <option value="{{$lab->id}}">{{$lab->lab_name}}</option>
                    @endforeach
                </select>
                @error('lab') <span class="text-red-500"> <i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Name <span class="text-danger">*</span></label>
                <input type="text" wire:model="name"  placeholder="Instrument name"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('name') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Model Number <span class="text-danger">*</span></label>
                <input type="text" wire:model="model_number"  placeholder="Model number"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('model_number') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Serial Number <span class="text-danger">*</span></label>
                <input type="text" wire:model="serial_number"  placeholder="Serial number"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('serial_number') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Description <span class="text-danger">*</span></label>
                <textarea wire:model="description" name="description" rows="1" placeholder="Enter category description"
                          class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"></textarea>
                @error('description') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>

            <div class="w-full lg:col-span-4 bg-primary/10 px-4 py-2 font-semibold text-primary mt-4 mb-4">
                Booking Information
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Operating Status <span class="text-danger">*</span></label>
                <select wire:model="operating_status" class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="working">Working</option>
                        <option value="under_maintenance">Under Maintenance</option>
                        <option value="calibration_required">Calibration Required</option>
                        <option value="faulty">Faulty</option>
                        <option value="retired">Retired/ Obsolete</option>
                </select>
                @error('operating_status') <span class="text-red-500"> <i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Per Hour Cost (₹) <span class="text-danger">*</span></label>
                <input type="number" wire:model="per_hour_cost"  placeholder="100 ₹"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('per_hour_cost') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Minimum Booking Duration (in minutes) <span class="text-danger">*</span></label>
                <input type="number" wire:model="minimum_booking_duration"  placeholder="30 min"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('minimum_booking_duration') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Maximum Booking Duration (in minutes) <span class="text-danger">*</span></label>
                <input type="number" wire:model="maximum_booking_duration"  placeholder="120 min"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('maximum_booking_duration') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full lg:col-span-4 bg-primary/10 px-4 py-2 font-semibold text-primary mt-4 mb-4">
                Purchase Information
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Manufacturer Name  <span class="text-danger">*</span></label>
                <input type="text" wire:model="manufacturer_name"  placeholder="Name"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('manufacturer_name') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Vendor Name  <span class="text-danger">*</span></label>
                <input type="text" wire:model="vendor_name"  placeholder="Name"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('vendor_name') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Manufacturing Date  <span class="text-danger">*</span></label>
                <input type="date" wire:model="manufacturing_date"  placeholder="Name"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('manufacturing_date') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Purchase Date  <span class="text-danger">*</span></label>
                <input type="date" wire:model="purchase_date"  placeholder="Name"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('purchase_date') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Purchase Order Number  <span class="text-danger">*</span></label>
                <input type="text" wire:model="purchase_order_number"  placeholder="Purchase order number"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('purchase_order_number') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Cost (₹) <span class="text-danger">*</span></label>
                <input type="number" wire:model="cost"  placeholder="Cost"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('cost') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Funding Source<span class="text-danger">*</span></label>
                <input type="text" wire:model="funding_source"  placeholder="Funding Source"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('funding_source') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Installation Date<span class="text-danger">*</span></label>
                <input type="date" wire:model="installation_date"  placeholder="Funding Source"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('installation_date') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Warranty Period (months)<span class="text-danger">*</span></label>
                <input type="number" wire:model="warranty_period"  placeholder="36 months"
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('warranty_period') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Next Service Date<span class="text-danger">*</span></label>
                <input type="date" wire:model="next_service_date"  placeholder=""
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('next_service_date') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>

            <div class="w-full lg:col-span-4 bg-primary/10 px-4 py-2 font-semibold text-primary mt-4 mb-4">
                Photos and Documents
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Instrument Photos<span class="text-danger">*</span></label>
                <input type="file" wire:model="photos"  placeholder="" multiple
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                <div wire:loading wire:target="photos" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading file... Please wait</div>

                @error('photos') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Operational Manual (pdf)</label>
                <input type="file" wire:model="operational_manual"  placeholder=""
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                <div wire:loading wire:target="operational_manual" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading file... Please wait</div>

                @error('operational_manual') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Service Manual (pdf)</label>
                <input type="file" wire:model="service_manual"  placeholder=""
                       class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                <div wire:loading wire:target="service_manual" class="text-sm text-danger"><i class="fas fa-hourglass-half fa-spin mr-2"></i> Uploading file... Please wait</div>
                @error('service_manual') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>
            <div class="w-full flex flex-col gap-1">
                <label class="font-semibold text-primary">Video Link (url)</label>
                <input type="text" wire:model="video_link"  placeholder="https://www.instrumentvideo.com"
                       class="px-2 py-2.5 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                @error('video_link') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i> {{ $message }}</span> @enderror
            </div>


        </div>
        <div class="w-full flex justify-end px-4 pb-4 gap-2">
            <button type="submit"
                    class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">
                <span wire:loading.remove wire:target="submit">
                    <i class="fa fa-{{$isEditing ? 'check' : 'plus'}} mr-2"></i>
                    {{$isEditing ? 'Update Instrument' : 'Create Instrument'}}
                </span>
                <span wire:loading wire:target="submit">
                    {{$isEditing ? 'Updating Instrument...' : 'Creating Instrument...'}} <i class="fas fa-hourglass-half fa-spin ml-2"></i>
                </span>
            </button>
        </div>
    </form>
</div>
