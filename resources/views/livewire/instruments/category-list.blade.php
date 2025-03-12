<div>
    <div wire:show="showForm" @if(!$showForm) style="display: none;" @endif class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300">
        <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
            <span class="font-semibold text-primary text-xl">{{ $isEditing ? 'Edit Category' : 'Category Registration' }}</span>
            <span class="text-sm bg-primary/30 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-primary hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer"><i class="fa fa-angle-left mr-2"></i>Back</span>
        </div>
        <div id="formDiv" class="w-full border-b-[2px] border-b-ternary/10 shadow-lg shadow-ternary/20">
            <livewire:instruments.category-form />
        </div>
    </div>
    <div wire:show="!showForm" class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 flex-col shadow-lg shadow-gray-300 mt-6">
        <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20 flex justify-between">
            <span class="font-semibold text-primary text-xl">Category List</span>
            <span wire:click="hideForm" class="text-sm bg-primary/80 px-4 py-1 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] font-semibold border-[2px] border-primary/80 text-white hover:text-white hover:bg-primary hover:border-ternary/30 transition ease-in duration-2000 cursor-pointer">
                <i class="fa fa-plus mr-2"></i>
                Create New Category</span>
        </div>
        <div class="w-full p-4">
            <div class="w-full flex justify-between gap-2 items-center">
                       <div class="flex gap-2">
                           <button title="{{$gridView?'List View':'Grid View'}}" wire:click="toggleGridView" class="bg-primary/20 text-primary h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-primary hover:text-white cursor-pointer transition ease-in duration-2000">
                               <i class="fa fa-{{$gridView?'list':'grip'}}"></i>
                           </button>
                   @if(!$gridView)
                           <button title="Export to pdf" wire:click="exportToPdf" class="bg-danger/20 text-danger h-8 w-8 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                               <i class="fa fa-file-pdf"></i>
                           </button>
                   @endif
                       </div>

                <div class="flex items-center gap-2">
                    <input type="text" wire:model.live.debounce.1000ms="search" name="search" required placeholder="Search Category" class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000"/>
                    <select wire:model.live="status" required class="px-2 py-1 w-full text-sm font-medium bg-transparent placeholder-primary/70 border-[2px] border-primary/40 rounded-[3px] rounded-tr-[8px] rounded-bl-[8px] focus:ring-0 focus:outline-none focus:border-primary transition ease-in duration-2000">
                        <option value="All">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            @if($gridView)
               <div class="w-full grid xl:grid-cols-10 lg:grid-cols-6 md:grid-cols-6 sm:grid-cols-4 grid-cols-2 mt-8 " wire:loading.class="opacity-25">
                @forelse ($categories as $category)
                   <div class="w-full p-2 flex flex-col items-center group cursor-pointer">
                       <div class=" relative ">
                       @if($category->status)
                           <img src="{{asset('assets/images/active.png')}}" class="h-32 group-hover:scale-110 transition ease-in duration-2000" alt="">
                       @else
                               <img src="{{asset('assets/images/inActive.png')}}" class="h-32 group-hover:scale-110 transition ease-in duration-2000" alt="">
                       @endif
                       </div>
                        <span class="text-center text-bold text-xs">{{$category->title}}</span>
                   </div>
                @empty
                  <div class="w-full flex justify-center xl:col-span-10 lg:col-span-6 md:col-span-6 sm:col-span-4 col-span-2">
                      <img src="{{asset('assets/images/no-data.gif')}}" class="max-h-96" alt="">
                  </div>
                @endforelse
            </div>
            @else
               <div class="w-full overflow-x-auto">
                <table class="w-full border-[2px] border-secondary/40 border-collapse mt-4" wire:loading.class="opacity-25">
                    <tr>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Sr. No.</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Title</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Description</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Status</td>
                        <td class="border-[2px] border-secondary/40 bg-gray-100 px-4 py-1.5 text-ternary/80 font-bold text-md">Action</td>
                    </tr>
                    @forelse ($categories as $category)
                        <tr class="hover:bg-secondary/10 cursor-pointer transition ease-in duration-2000">
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$loop->iteration}}</td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$category->title}}</td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">{{$category->description}}</td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <button wire:click="toggleStatus({{ $category->id }})" class="focus:outline-none">
                                    @if($category->status == '0')
                                        <span class="bg-danger/20 text-danger px-2 py-0.5 rounded-full text-xs">Inactive</span>
                                    @else
                                        <span class="bg-success/20 text-success px-2 py-0.5 rounded-full text-xs">Active</span>
                                    @endif
                                </button>
                            </td>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm">
                                <div class="flex gap-2">
                                    <button wire:click="editCategory({{ $category->id }})" title="Edit" class="bg-warning/20 text-warning h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-warning hover:text-white cursor-pointer transition ease-in duration-2000">
                                        <i class="fa fa-pen text-xs"></i>
                                    </button>
                                    <button wire:click="deleteCategory({{ $category->id }})" wire:confirm="Are you sure you want to delete this category?" title="Delete" class="bg-danger/20 text-danger h-6 w-6 flex justify-center items-center rounded-[3px] hover:bg-danger hover:text-white cursor-pointer transition ease-in duration-2000">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border-[2px] border-secondary/40 px-4 py-1.5 text-ternary/80 font-medium text-sm text-center" colspan="5">No categories found</td>
                        </tr>
                    @endforelse
                </table>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
            @endif


        </div>
    </div>
</div>
