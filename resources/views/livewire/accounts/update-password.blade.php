<div>
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-6 z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full relative">
                <h3 class="text-lg font-semibold mb-4 text-primary">Update Password</h3>
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
                <form wire:submit="updatePassword">
                    <div class="w-full flex flex-col gap-4">
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">New Password <span class="text-danger">*</span></label>
                            <input type="password" wire:model="newPassword" placeholder="Enter new password"
                                   class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            @error('newPassword') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label class="font-semibold text-primary">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" wire:model="confirmPassword" placeholder="Confirm new password"
                                   class="px-2 py-2 w-full text-sm font-medium bg-transparent placeholder-black border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                            @error('confirmPassword') <span class="text-red-500"><i class="fa fa-triangle-exclamation mr-2"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" onclick="document.getElementById('passwordUpdateDiv').classList.toggle('hidden')"
                                class="text-sm bg-success/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-success/90 text-ternary hover:text-white hover:bg-success hover:border-ternary/30 transition ease-in duration-2000">
                            Cancel
                        </button>
                        <button type="submit"
                                class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/90 text-ternary hover:text-white hover:bg-primary hover:border-primary/30 transition ease-in duration-2000">
                            <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                            <span wire:loading wire:target="updatePassword">Updating... <i class="fas fa-hourglass-half fa-spin ml-2"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
</div>
