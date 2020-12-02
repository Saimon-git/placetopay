<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel = "icon" type="image/png" href="{{ config('app.logo_compacted') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ga-code" content="{{ env('GOOGLE_ANALYTICS_CODE') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="h-screen antialiased leading-none bg-gray_body">
<div id="app" class="h-full">
    <div class="container mx-auto pt-8">
        <div class="flex flex-col flex-wrap">
            @include('partials.top-logo')
            @yield('content')
        </div>
    </div>
</div>
<!-- Scripts -->
<!-- Google Analytics -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', "{{ env('GOOGLE_ANALYTICS_CODE') }}", 'auto');
    ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
@if(config('app.env') === 'production')
<!-- Fathom - beautiful, simple website analytics -->
<script src="https://cdn.usefathom.com/script.js" spa="auto" site="{{ env('PHATOM_CODE') }}" defer></script>
<!-- / Fathom -->
@endif
</body>
</html>
