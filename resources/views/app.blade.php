<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Airentibarabino') }}</title>

    <!-- Fonts -->

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/favicons/apple-touch-icon.png') }}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicons/favicon-32x32.png') }}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicons/favicon-16x16.png') }}"/>

    <link rel="manifest" href="{{ asset('/images/favicons/site.webmanifest') }}"/>
    <meta name="description" content="Consultant Advisor Company providing expert business consulting, financial advisory, strategic planning, and professional services to help businesses grow and succeed." />
    <meta name="google" content="notranslate" />

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet"/>


    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/animate/animate.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/animate/custom-animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/jarallax/jarallax.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/odometer/odometer.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/swiper/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/outscalers-icons/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/the-sayinistic-font/stylesheet.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.theme.default.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/outscalers.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/outscalers-responsive.css') }}"/>

    <!-- Scripts via Vite -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia

    <!-- Vendor JS -->
    <script src="{{ asset('vendors/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/jarallax/jarallax.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendors/odometer/odometer.min.js') }}"></script>
    <script src="{{ asset('vendors/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('vendors/wow/wow.js') }}"></script>
    <script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/lang.it.js') }}"></script>
    <script src="{{ asset('js/outscalers.js') }}"></script>
    <script src="{{ asset('js/translation.js') }}"></script>
</body>
</html>
