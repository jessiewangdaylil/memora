<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
       <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.1/dist/cdn.min.js"></script>
           @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
         @livewireScripts
        <script>
          <!-- Flash Message Overlay會用到，需保留 -->
            $('#flash-overlay-modal').modal();
          <!-- Flash Message 3秒之後消失，非必須 -->
         $('div.alert').delay(3000).fadeOut(350);
        </script>
    </body>

</html>
