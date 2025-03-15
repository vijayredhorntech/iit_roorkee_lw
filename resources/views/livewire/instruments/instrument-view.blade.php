<div>
     @if(!$showBookingDetailsTable)
        <!-- Main Info Card -->
        <div class=" w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col">
            <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between items-center">

                <span class="font-semibold text-primary text-xl">Instrument Details</span>

               <div class="flex items-center gap-4">
                   <button wire:click="showForm" class="text-sm bg-success/20 text-success px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/80 hover:text-white hover:bg-success hover:border-success/30 transition ease-in duration-2000">
                       <i class="fa fa-eye mr-2"></i>View Bookings
                   </button>
                   <button wire:click="hideViewInstrument" class="text-sm bg-danger/20 text-danger px-2 py-0.5 mr-2 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-danger/80 hover:text-white hover:bg-danger hover:border-danger/30 transition ease-in duration-2000">
                       <i class="fa fa-xmark"></i>
                   </button>
               </div>

            </div>
            <div class="p-4 grid xl:grid-cols-2 gap-4">
                <!-- Basic Info -->
                <div class="flex flex-col gap-2">
                    <h3 class="font-semibold text-primary text-lg">Basic Information</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm text-black">
                        <span>Name:</span>
                        <span class="font-semibold">{{$instrument->name}} </span>
                        <span>Model Number:</span>
                        <span class="font-semibold">{{$instrument->model_number}}</span>
                        <span>Serial Number:</span>
                        <span class="font-semibold">{{$instrument->serial_number}}</span>
                        <span>Category:</span>
                        <span class="font-semibold">{{$instrument->instrumentCategory->title}}</span>
                        <span>Lab:</span>
                        <span class="font-semibold">{{$instrument->lab->lab_name}}</span>
                        <span>Status:</span>
                        <span class="font-semibold">{{$instrument->operating_status}}</span>
                        <span>Accessories:</span>
                        <span class="font-semibold"> {{$instrument->instrumentAccessories->count()}}</span>
                        <span>Description:</span>
                        <span class="font-semibold"> {{$instrument->description}}</span>
                    </div>
                </div>


                <!-- Purchase Information -->
                <div class="flex flex-col gap-2">
                    <h3 class="font-semibold text-primary text-lg">Purchase Information</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <span>Manufacturer:</span>
                        <span class="font-semibold">{{$instrument->purchaseInformation->manufacturer_name??''}}</span>
                        <span>Vendor:</span>
                        <span class="font-semibold">{{$instrument->purchaseInformation->vendor_name??''}}</span>
                        <span>Manufacturing Date:</span>
                        <span class="font-semibold">{{$instrument->purchaseInformation->manufacturing_date??''}}</span>
                        <span>Purchase Date:</span>
                        <span class="font-semibold">{{ $instrument->purchaseInformation->purchase_date??'' }}</span>
                        <span>Installation Date:</span>
                        <span class="font-semibold">{{ $instrument->purchaseInformation->installation_date??'' }}</span>
                        <span>Purchase Order Number:</span>
                        <span class="font-semibold">{{ $instrument->purchaseInformation->purchase_order_number??'' }}</span>
                        <span>Purchase Cost:</span>
                        <span class="font-semibold">{{ $instrument->purchaseInformation->cost??'' }} ₹</span>
                        <span>Funding Source:</span>
                        <span class="font-semibold">{{ $instrument->purchaseInformation->funding_source??'' }}</span>
                        <span>Warranty Period: </span>
                        <span class="font-semibold">{{ $instrument->purchaseInformation->warranty_period??'' }} months</span>
                    </div>
                </div>

                <!-- Cost & Booking Info -->
                <div class="flex flex-col gap-2">
                    <h3 class="font-semibold text-primary text-lg">Booking Information</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <span>Cost per Hour:</span>
                        <span class="font-semibold">₹{{$instrument->per_hour_cost}}</span>
                        <span>Min. Duration:</span>
                        <span class="font-semibold">{{$instrument->minimum_booking_duration}} Hours</span>
                        <span>Max. Duration:</span>
                        <span class="font-semibold">{{$instrument->maximum_booking_duration}} Hours</span>
                        <span>Upcoming Booking:</span>
                        <span class="font-semibold">{{$instrument->getNextBookingDateTime()}}</span>
                        <span>Next Slot Available:</span>
                        <span class="font-semibold">{{$instrument->getNextAvailableSlot()}}</span>
                    </div>
                </div>

                <!-- Service Information -->
                <div class="flex flex-col gap-2">
                    <h3 class="font-semibold text-primary text-lg">Service Information</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <span>Service Engineer:</span>
                        <span class="font-semibold">{{$instrument->engineer_name}}</span>
                        <span>Contact Number:</span>
                        <span class="font-semibold">{{$instrument->engineer_mobile}}</span>
                        <span>Email: </span>
                        <span class="font-semibold">{{$instrument->engineer_email}}</span>
                        <span>Address: </span>
                        <span class="font-semibold">{{$instrument->engineer_address}}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Photos & Documents Section -->
        <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col mt-4">
            <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20">
                <span class="font-semibold text-primary text-lg">Photos & Documents</span>
            </div>
            <div class="p-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-4">
                @php
                    $photos = $instrument->photos ? json_decode($instrument->photos, true) : [];
                @endphp
                @forelse($photos as $photo)
                    <div class="border rounded-lg p-2 hover:shadow-lg transition">
                        <a href="{{asset('storage/'.$photo)}}" target="_blank">
                            <img src="{{asset('storage/'.$photo)}}" alt="{{$instrument->name}}" class="w-full h-48 object-cover rounded">

                        </a>
                    </div>
                @empty
                    <div class="border rounded-lg p-2 hover:shadow-lg transition">
                        <img src="{{asset('assets/images/noProductImage.jpg')}}" alt="{{$instrument->name}}" class="w-full h-48 object-cover rounded">
                    </div>
                @endforelse
            </div>

            <!-- Documents -->
            <div class="px-4 pb-4 flex flex-wrap gap-4">

                @if($instrument->operational_manual)
                    <a href="{{asset('storage/'.$instrument->operational_manual)}}"
                       target="_blank"
                       class="flex items-center gap-2 px-8 py-2 border rounded-lg hover:bg-gray-50">
                        <i class="fa fa-file-pdf text-danger text-2xl"></i>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold">Operation Manual</span>
                            <span class="text-xs text-gray-500">PDF, 2.5 MB</span>
                        </div>
                    </a>
                @endif
                @if($instrument->service_manual)
                    <a href="{{asset('storage/'.$instrument->service_manual)}}"
                       target="_blank"
                       class="flex items-center gap-2 px-8 py-2 border rounded-lg hover:bg-gray-50">
                        <i class="fa fa-file-pdf text-danger text-2xl"></i>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold">Service Manual</span>
                            <span class="text-xs text-gray-500">PDF, 2.5 MB</span>
                        </div>
                    </a>
                @endif
                @if($instrument->video_link)
                    <a href="{{asset('storage/'.$instrument->video_link)}}" title="Instrument Related Video" target="_blank" class="flex items-center gap-2 px-8 py-2 border rounded-lg hover:bg-gray-50">
                        <img src="{{asset('assets/images/watchVideo.png')}}" class="h-12 w-auto" alt="Instrument Related Video">
                    </a>
                @endif

            </div>
        </div>

        <!-- Accessories Section -->
        <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col mt-4">
            <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20">
                <span class="font-semibold text-primary text-lg">Instrument Accessories</span>
            </div>
            <div class="p-4 grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-4">
                @forelse($instrument->instrumentAccessories as $accessory)
                    <div class="border rounded-lg p-4 hover:shadow-lg transition flex flex-col gap-2">
                        <div class="relative h-48 w-full overflow-hidden rounded-lg">
                            <img src="{{asset('storage/'.$accessory->photo)}}" alt="{{$accessory->name}}" class="w-full h-full object-cover">
                            <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-semibold {{$accessory->status === 'available' ? 'bg-success/20 text-success' : 'bg-danger/20 text-danger'}}">
                                {{ucfirst($accessory->status)}}
                            </span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <h4 class="font-semibold text-primary">{{$accessory->name}}</h4>
                            <div class="text-sm text-gray-600">
                                <p><span class="font-medium">Model:</span> {{$accessory->model_number}}</p>
                                <p><span class="font-medium">Purchase Date:</span> {{$accessory->purchase_date}}</p>
                                <p><span class="font-medium">Price:</span> ₹{{$accessory->price}}</p>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{$accessory->description}}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <i class="fa fa-box-open text-4xl mb-2"></i>
                        <p>No accessories available for this instrument.</p>
                    </div>
                @endforelse
            </div>
        </div>
         @else
        <!-- Booking Details Table -->
         <livewire:instruments.instrument-booking-table :instrument="$instrument"/>
    @endif
</div>

