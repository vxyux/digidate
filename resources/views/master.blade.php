<head>
    <title>DigiDate</title>

    {{--Fonts (Google: Archivo)--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,500;1,700&family=Spline+Sans:wght@300;400;500;600;700&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{--Side-loading icons--}}
    <script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js">
    </script>
    <script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js">
    </script>

    {{--AOS package--}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    {{--Bootstrap--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    {{--Custom stylesheets--}}
    <link rel="stylesheet" href="{{ URL::asset('css/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/matchmaking.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/chat.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/checkout.css') }}">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script src="https://kit.fontawesome.com/5860913b3e.js" crossorigin="anonymous"></script>
</head>

{{--Content--}}
@if(Route::currentRouteName() == 'email-verify' || Route::currentRouteName() == 'email-verify')
    {{-- --}}
@else
    @include('layouts.navigation')
@endif

@include('layouts.error')
@yield('content')

@include('layouts.footer')

<footer>
    <script src="{{ URL::asset('js/sidebar.js') }}"></script>
    <script src="{{ URL::asset('js/matchmaking.js') }}"></script>
    <script src="{{ URL::asset('js/chat.js') }}"></script>

</footer>

<script>
    AOS.init();
</script>

