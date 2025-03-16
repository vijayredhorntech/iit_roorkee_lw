<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IIT-ROORKEE</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/images/whiteLogo.png')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        ::-webkit-scrollbar {
            width: 2px;
            height: 2px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #001A6E;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }


        input[type="date"]::-webkit-datetime-edit {
            color: #172432b3; /* Change placeholder text color */
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }


        select {
            -webkit-appearance: none !important; /* Hides the arrow in WebKit-based browsers (Chrome, Safari, Edge) */
            -moz-appearance: none !important; /* Hides the arrow in Firefox */
            appearance: none !important; /* Standard property */
            background: white !important;
            color: rgba(75, 85, 99, 0.7); /* Removes background if needed */
        }

        select option {
            color: rgba(75, 85, 99, 0.9); /* Match placeholder text */
            background-color: #ffffff; /* Ensure options have a white background */
        }
    </style>

</head>
<body class="bg-gray-100 relative"
      style="font-family: 'Public Sans', serif; height: 100vh; width: 100%; overflow:hidden">
<div id="sideBarOverlay" class="xl:w-0 lg:w-0  h-full bg-black/40 absolute top-0 left-0 z-40"
     onclick="document.getElementById('sideBarDiv').classList.toggle('hidden');document.getElementById('sideBarOverlay').classList.toggle('w-full');"></div>

<div class="flex w-full ">
    <div id="sideBarDiv"
         class="z-20 w-72 p-4 h-[100vh] bg-primary overflow-x-hidden overflow-y-auto flex-none xl:static lg:static absolute top-0 left-0 xl:block lg:block hidden z-50">
        <div
            class="w-full flex flex-col justify-center items-center border-b-[1px] pb-2 border-b-gray-100/20 shadow-lg shadow-gray-700/10">
            <img src="{{asset('assets/images/whiteLogo.png')}}" class="h-32 w-auto" alt="Cloud Travel">
            <span class="font-semibold text-white/80 mt-2 text-2xl">IIT ROORKEE</span>
            <p class="text-primaryLight text-xs"><i class="fa-solid fa-flask mr-1"></i>
                Department of Biological Science
            </p>
        </div>

        <div class="w-full flex flex-col mt-12 gap-3">
            @if(auth()->user()->hasRole('super_admin'))
                <a href="{{route('dashboard')}}">
                    <div
                        class=" {{Route::currentRouteName()==='dashboard'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa fa-tv mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Dashboard</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endif

            @can ('create pi')
                <a href="{{route('pi.list')}}">
                    <div
                        class=" {{Route::currentRouteName()==='pi.list'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa fa-user mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Principle Investigator</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endcan

            @can ('create lab')
                <a href="{{route('lab.list')}}">
                    <div
                        class=" {{Route::currentRouteName()==='lab.list'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa-solid fa-flask mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Labs</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endcan

            @can ('create student')
                <a href="{{route('student.list')}}">
                    <div
                        class=" {{Route::currentRouteName()==='student.list'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa fa-user-graduate mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Students</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endcan
            @can ('create instrumentCategory')
                <a href="{{route('instrument.instrument-category')}}">
                    <div
                        class=" {{Route::currentRouteName()==='instrument.instrument-category'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa fa-layer-group mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Instrument Category</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endcan

            @can ('view instrument')
                <a href="{{route('instrument.instrument')}}">
                    <div
                        class=" {{Route::currentRouteName()==='instrument.instrument'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa fa-microscope mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Instruments</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endcan
            @can('create bookings')
                <a href="{{route('bookings.create')}}">
                    <div
                        class=" {{Route::currentRouteName()==='bookings.create'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa fa-calendar-days mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Bookings</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endcan
            @can('view instrument complaint')
                <a href="{{route('instrument.complaints')}}">
                    <div
                        class=" {{Route::currentRouteName()==='instrument.complaints'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                        <div class="flex items-center">
                            <i class="fa fa-exclamation-triangle mr-2 text-sm"></i>
                            <span class="text-lg font-medium">Instrument Complaint</span>
                        </div>
                        <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                    </div>
                </a>
            @endcan
            @can('view instrument services')
            <a href="{{route('instrument.service')}}">
                <div
                    class=" {{Route::currentRouteName()==='instrument.service'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                    <div class="flex items-center">
                        <i class="fa fa-hammer mr-2 text-sm"></i>
                        <span class="text-lg font-medium">Instrument Services</span>
                    </div>
                    <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                </div>
            </a>
          @endcan
            @can('account settings')
            <a href="{{route('account.settings')}}">
                <div
                    class=" {{Route::currentRouteName()==='account.settings'?'bg-primaryLight/90 border-[2px] border-white text-primary':'border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10'}} w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                    <div class="flex items-center">
                        <i class="fa fa-user-shield mr-2 text-sm"></i>
                        <span class="text-lg font-medium">Admin Settings</span>
                    </div>
                    <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                </div>
            </a>
          @endcan
                <div onclick="document.getElementById('passwordUpdateDiv').classList.toggle('hidden')"  class="cursor-pointer border-[2px] border-primary  bg-primary text-white/90 hover:bg-primaryLight/10 w-full flex justify-between items-center py-1 px-4 rounded-[3px] relative transition ease-in duration-2000">
                    <div class="flex items-center">
                        <i class="fa fa-lock-open mr-2 text-sm"></i>
                        <span class="text-lg font-medium">Update Password</span>
                    </div>
                    <div class="h-16 w-12 bg-primary absolute top-1 -right-6 rotate-45"></div>
                </div>

        </div>
        <div class="hidden" id="passwordUpdateDiv">
            <livewire:accounts.update-password/>
        </div>


    </div>


    <div class=" h-[100vh] w-full overflow-y-auto">
        <div
            class="w-full px-4 py-2 flex xl:justify-between lg:justify-between md:justify-between sm:justify-between justify-between items-center bg-white sticky top-0 border-b-[2px] border-b-primary/20 z-20">
            <div class="flex items-center">
                <div class="rounded-full h-10 w-10 xl:hidden lg:hidden flex justify-center items-center text-secondary"
                     onclick="document.getElementById('sideBarDiv').classList.toggle('hidden');
                             document.getElementById('sideBarOverlay').classList.toggle('w-full');"><i
                        class="fa fa-bars text-xl" title="Search......"></i></div>
                <span class="font-bold text-primary text-xl xl:block lg:block md:block sm:block hidden">
                   @if(auth()->user()->hasRole('super_admin'))
                    Super Admin Dashboard
                    @elseif(auth()->user()->hasRole('pi'))
                    Principle Investigator Dashboard
                    @else
                    Student Dashboard
                    @endif
                </span>

            </div>
            <div class="w-max flex items-center">

{{--                <div--}}
{{--                    class="rounded-full h-10 w-10 flex text-primary justify-center items-center hover:bg-primary/60 hover:text-white cursor-pointer transition ease-in duration-2000 relative">--}}
{{--                    <div--}}
{{--                        class="absolute top-0 right-0 text-xs text-white bg-primary font-semibol h-4 w-4 rounded-full flex justify-center items-center">--}}
{{--                        5--}}
{{--                    </div>--}}
{{--                    <i class="fa fa-bell" title="Search......"></i>--}}
{{--                </div>--}}

                <div class="flex items-center ̥gap-2 mx-4 cursor-pointer relative">
                    <div class="">
                        @if(auth()->user()->hasRole('super_admin'))
                            <img src="{{asset('assets/images/logo.png')}}" class="w-auto h-10 rounded-full"
                                 alt="{{auth()->user()->name}}">
                        @elseif(auth()->user()->hasRole('pi'))
                            <img
                                src="{{asset('storage/'. auth()->user()->principalInvestigators->first()->profile_photo)}}"
                                class="w-auto h-10 rounded-full"
                                alt="{{auth()->user()->name}}">
                        @else
                            <img src="{{asset('storage/'. auth()->user()->students->first()->profile_photo)}}"
                                 class="w-auto h-10 rounded-full"
                                 alt="{{auth()->user()->name}}">
                        @endif
                    </div>
                    <div class="flex flex-col items-start justify-center ml-4">
                        <span class="text-primary text-sm font-semibold">{{auth()->user()->name}}</span>
                        <span class="text-primary/90 text-xs font-semibol">{{auth()->user()->email}}</span>
                    </div>
                    @if(auth()->user())
                        <livewire:pages.auth.logout/>
                    @endif

                </div>
            </div>
        </div>

        <div class="p-4 w-full relative pb-12" style="min-height: 90vh">
            {{ $slot }}
        </div>

        <div class="w-full px-4 py-2 flex xl:justify-between lg:justify-between md:justify-between flex-wrap items-center bg-white sticky bottom-0 border-t-[2px] border-b-primary/20">
            <div class="flex items-center gap-2">
                <span class="text-black/70 text-sm font-semibold">
                    &copy; {{date('Y')}}
                </span>
                <span class="text-primary text-sm font-semibold hover:text-danger transition ease-in duration-2000">IIT ROORKEE</span>
            </div>
            <div>
                <span class="text-black/70 text-sm font-semibold">Developed by:</span>
                <a href="https://himsoftsolution.com" target="_blank"
                   class="mt-2 text-primary text-md font-semibold hover:text-danger transition ease-in duration-2000">Him
                    Soft Solution</a>
            </div>
        </div>

    </div>
</div>


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
@stack('scripts')

<script>
    setTimeout(function () {
        document.getElementById('successMessage').classList.add('hidden');
        document.getElementById('dangerMessage').classList.add('hidden');

    }, 3000);
</script>
</body>
</html>

