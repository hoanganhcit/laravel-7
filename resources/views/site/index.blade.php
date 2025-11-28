<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $description }}">
    <meta name="author" content="Thái Bá Hoàng Anh">
    <meta name="generator" content="Cosmetics">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ config('app.url') }}">
    <title>{{ $title }} </title>
    <link rel="canonical" href="{{ $canonical }}" />
    <link rel='shortlink' href="{{ $canonical }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Zetta:wght@100;200;300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/fontawesome-pro-5/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/bootstrap-select/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/slick/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/magnific-popup/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/mapbox-gl/mapbox-gl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/fonts/font-phosphor/css/phosphor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/fonts/tuesday-night/stylesheet.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/fonts/butler/stylesheet.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/vendors/fonts/a-antara-distance/stylesheet.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/themes.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/responsive.css') }}">
    
    <style>
        .swatches-item {
            transition: all 0.3s ease;
        }
        .swatches-item.selected {
            border-color: #212529 !important;
            background-color: #212529 !important;
            color: #fff !important;
            font-weight: 600;
        }
        .swatches-item:hover {
            border-color: #212529 !important;
        }
    </style>
    
    @php
        $settings = App\Models\Setting::first();
        $favicon = $settings->favicon ?? null;
        
    @endphp
    @if ($favicon)
        <link rel="icon" href="{{ $favicon }}" sizes="16x16">
    @else
        <link rel="icon" href="{{ asset('public/site/images/favicon.webp') }}">
    @endif

    @yield('styles')

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="images/logo_01.png')}}">

    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="images/logo_01.png')}}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

</head>

<body>
    @include('site.partials.header')
    
    <main id="content">
        @yield('content')
    </main>
    @include('site.partials.footer')
    

    <script src="{{ asset('public/site/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('public/site/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/site/vendors/bootstrap/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('public/site/vendors/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('public/site/vendors/slick/slick.min.js') }}"></script>
    <script src="{{ asset('public/site/vendors/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('public/site/vendors/counter/countUp.js') }}"></script>
    <script src="{{ asset('public/site/vendors/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('public/site/vendors/jparallax/TweenMax.min.js') }}"></script>
    <script src="{{ asset('public/site/vendors/mapbox-gl/mapbox-gl.js') }}"></script>
    <script src="{{ asset('public/site/vendors/isotope/isotope.js') }}"></script>

    <script src="{{ asset('public/site/js/theme.js') }}"></script>

    <script src="{{ asset('public/site/js/custom.js') }}"></script>
    <script src="{{ asset('public/site/js/alertify.min.js') }}"></script>
    <script src="{{ asset('public/site/js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('public/site/js/cart.js') }}"></script>

    <div class="position-fixed pos-fixed-bottom-right p-6 z-index-10">
        <a href="#"
            class="gtf-back-to-top text-decoration-none bg-white text-primary hover-white bg-hover-primary shadow p-0 w-48px h-48px rounded-circle fs-20 d-flex align-items-center justify-content-center"
            title="Back To Top"><i class="fal fa-arrow-up"></i></a>
    </div>
    

    @include('site.pages.products._quickview')
    @include('site.partials.sidebar-cart')  

    @yield('scripts')
    @stack('scripts')
    <script>
        
    </script>
</body>

</html>
