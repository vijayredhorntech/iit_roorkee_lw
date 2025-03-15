<div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col mt-4">
    <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20">
        <span class="font-semibold text-primary text-lg">Bookings</span>
    </div>
    <div class="p-4">
        <!-- Search Filters -->

        <div class="w-full flex justify-between gap-2 items-center mb-2">
            <div class="flex gap-2">
                <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                    <i class="fa fa-file-pdf"></i>
                </button>
            </div>
            <div class="flex items-center gap-2">
                <input type="date" wire:model.live="search_date" name="search" required placeholder="Search Bookings"
                       class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>

                <select wire:model.live="search_instrument" required
                        class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                    <option value="">-- Search instrument---</option>
                    @foreach($instruments as $instrument)
                        <option value="{{$instrument->id}}">{{$instrument->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>



        <div class="relative overflow-x-auto">
            <table class="w-full border-[2px] border-secondary/40 border-collapse">
                <tr>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Date</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Instrument</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Slot</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                    <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Cost</td>
                </tr>
                @forelse($bookings as $booking)
                    <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{Carbon\Carbon::parse($booking->date)->format('d M, Y')}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$booking->instrument->name}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$booking->slot->start_time}} - {{$booking->slot->end_time}}</td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                    <span>
                                        @if($booking->status == 'confirmed')
                                            <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Confirmed</span>
                                        @else
                                            <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Cancelled</span>
                                        @endif
                                    </span>

                            <span><i class="fa-regular text-{{$booking->status == 'confirmed'?'success':'danger'}} fa-comment mr-2"></i>{{$booking->description??'--'}}</span>
                        </td>
                        <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                            @if($booking->status == 'confirmed')
                                {{$booking->instrument->per_hour_cost * (abs(Carbon\Carbon::parse($booking->slot->end_time)->diffInMinutes(Carbon\Carbon::parse($booking->slot->start_time))) / 60)}} ₹
                            @else
                                <span class="text-danger">No fee applied</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="border-[2px] border-secondary/40 px-4 py-1 text-ternary/80 font-medium text-sm text-center" colspan="6">No bookings found</td>
                    </tr>
                @endforelse
            </table>
            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
