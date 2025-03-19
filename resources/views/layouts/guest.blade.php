
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/images/whiteLogo.png') }}" type="image/x-icon"/>

    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<!-- rest of your HTML code remains the same -->
<body class="flex min-h-screen items-center justify-center p-4 bg-gray-900 bg-opacity-60" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url({{asset('assets/images/loginBg.jpg')}}); background-size: cover; background-position: center; font-family: Roboto">

<div class="w-full max-w-lg bg-gray-300 border-2 border-gray-400 px-6 py-10 rounded-lg shadow-lg">
    <div class="w-full flex justify-center items-center flex-col">
        <img src="{{asset('assets/images/logo.png')}}" class="lg:h-40 md:h-40 sm:h-36 h-32 w-auto" alt="IITR Logo"/>
    </div>
    <div class="mt-4 flex flex-col items-center text-center">
        <span class="lg:text-[35px] md:text-[30px] sm:text-[28px] text-[25px] font-semibold text-primary">"KINKAR"</span>
        <span class="lg:text-[20px] md:text-[20px] sm:text-[17px] text-[15px] font-semibold text-primary">Instrument Booking System</span>
        <div class="w-[90%]">
            <p class="lg:text-xs md:text-xs sm:text-xs text-[10px] text-gray-600">Department of Biological Science</p>
        </div>
    </div>
    <div class="mt-8">
            {{ $slot }}
    </div>
</div>

</body>
</html>

