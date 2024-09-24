<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Вход в аккаунт' }}</title>
    <link type="image/x-icon" rel="shortcut icon" href=" {{ secure_asset('favicon.ico') }}">

<!-- Дополнительные иконки для десктопных браузеров -->
<link type="image/png" sizes="16x16" rel="icon" href="{{ secure_asset('icon/favicon-16x16.png') }}">
<link type="image/png" sizes="32x32" rel="icon" href="{{ secure_asset('icon/favicon-32x32.png') }}">
<link type="image/png" sizes="96x96" rel="icon" href="{{ secure_asset('icon/favicon-96x96.png') }}">
<link type="image/png" sizes="120x120" rel="icon" href="{{ secure_asset('icon/favicon-120x120.png') }}">

<!-- Иконки для Android -->
<link type="image/png" sizes="72x72" rel="icon" href="{{ secure_asset('icon/android-icon-72x72.png') }}">
<link type="image/png" sizes="96x96" rel="icon" href=""{{ secure_asset('icon/android-icon-96x96.png') }}>
<link type="image/png" sizes="144x144" rel="icon" href="{{ secure_asset('icon/android-icon-144x144.png') }}">
<link type="image/png" sizes="192x192" rel="icon" href="{{ secure_asset('icon/android-icon-192x192.png') }}">
<link type="image/png" sizes="512x512" rel="icon" href="{{ secure_asset('icon/android-icon-512x512.png') }}">
<link rel="manifest" href="icon/{{ secure_asset('manifest.json') }}">

<!-- Иконки для iOS (Apple) -->
<link sizes="57x57" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-57x57.png') }}">
<link sizes="60x60" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-60x60.png') }}">
<link sizes="72x72" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-72x72.png') }}">
<link sizes="76x76" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-76x76.png') }}">
<link sizes="114x114" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-114x114.png') }}">
<link sizes="120x120" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-120x120.png') }}">
<link sizes="144x144" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-144x144.png') }}">
<link sizes="152x152" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-152x152.png') }}">
<link sizes="180x180" rel="apple-touch-icon" href="{{ secure_asset('icon/apple-touch-icon-180x180.png') }}">

<!-- Иконки для MacOS (Apple) -->
<link color="#e52037" rel="mask-icon" href="icon/safari-pinned-tab.svg">

<!-- Иконки и цвета для плиток Windows -->
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-TileImage" content="./icon/mstile-144x144.png">
<meta name="msapplication-square70x70logo" content="./icon/mstile-70x70.png">
<meta name="msapplication-square150x150logo" content="./icon/mstile-150x150.png">
<meta name="msapplication-wide310x150logo" content="./icon/mstile-310x310.png">
<meta name="msapplication-square310x310logo" content="./icon/mstile-310x150.png">
<meta name="application-name" content="My Application">
<meta name="msapplication-config" content="browserconfig.xml">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/modal.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/mobile.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/font.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('header')
            @yield('content')
            @yield('home')
            @yield('slider')
            @yield('banner')
            @yield('games')
            @yield('faq')
            @yield('footer')
            @yield('register-group')
            @yield('register-quiz')
            @yield('register-solo')
            @yield('register-groupPage')
            @yield('register-quizPage')
            @yield('register-soloPage')
            @yield('thanky')
            @yield('thankyPage')
            @yield('profileModal')
            @yield('offlineModal')
            @yield('offlineModalYES')
            @yield('profileDelete')
        </main>
    </div>
    <script src="{{ secure_asset('assets/js/burger-toggle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ secure_asset('assets/js/modal.js') }}"></script>
    <script src="{{ secure_asset('assets/js/togglePassword.js') }}"></script>
    <script src="{{ secure_asset('assets/js/profileModal.js') }}"></script>
    <script src="{{ secure_asset('assets/js/maskTg.js') }}"></script>
    <script src="{{ secure_asset('assets/js/maskSaves.js') }}"></script>
    <script src="{{ secure_asset('assets/js/profileerror.js') }}"></script>
    <script src="{{ secure_asset('assets/js/select.js') }}"></script>
    <script src="{{ secure_asset('assets/js/city.js') }}"></script>
    <script src="{{ secure_asset('assets/js/profileerrorModal.js') }}"></script>
    {{-- <script src="{{ secure_asset('assets/js/validator.js') }}"></script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    @for ($i = 1; $i <= 6; $i++)
        setupCityAutocomplete('city__participant_{{ $i }}', 'city-list-{{ $i }}');
    @endfor
});
</script>
    <script>
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            slidesPerView: 1.25,
            spaceBetween: 30,
            breakpoints: {
                768: {
                    slidesPerView: 1.2,
                    spaceBetween: 50,
                },
                480: {
                    slidesPerView: 0.5,
                    spaceBetween: 50,
                },
            }
        });
    </script>
</body>
</html>
