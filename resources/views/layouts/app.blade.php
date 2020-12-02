<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <link rel = "icon" type="image/png" href="{{ config('app.logo_compacted') }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="h-screen antialiased leading-none bg-gray_body">
<div id="app" class="h-full">
    <div class="flex h-full flex-wrap">
        @yield('aside')
        <div class="w-full m-1/5 bg-gray_body" id="content-ppal">
            @include('layouts.header')
            <div class="flex flex-wrap">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
@if(Auth::user())
    <script>
        window.user = {!! json_encode(Auth::user()->forFront()) !!}
    </script>
@endif
<script src="{{ mix('js/app.js') }}"></script>
@if(config('app.env') === 'production')
<!-- Fathom - beautiful, simple website analytics -->
<script src="https://cdn.usefathom.com/script.js" spa="auto" site="{{ env('PHATOM_CODE') }}" defer></script>
<!-- / Fathom -->
@endif
</body>
</html>
