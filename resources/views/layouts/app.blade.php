<!DOCTYPE html>
<html class="scroll-smooth" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="web_standard" name="shell-type" />
    <meta name="description" content="@yield('meta_description', 'Rahmat Tailor - Penjahit Jas, Batik Tulis & Kebaya Adibusana Bespoke Menteng Jakarta Pusat sejak 1996.')" />
    <title>@yield('title', 'Rahmat Tailor')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Tailwind Config & Vite Assets (Modular CSS & JS) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    @vite(['resources/css/style.css', 'resources/js/main.js'])

    @stack('styles')
</head>

<body class="bg-surface font-body-md text-body-md text-on-surface antialiased selection:bg-primary/20 selection:text-charcoal min-h-screen flex flex-col">
    <!-- Navbar Component -->
    @include('layouts.navbar')

    <!-- Main Content Slot -->
    <main class="flex-grow @yield('main_class', 'pt-20 bg-surface')">
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('layouts.footer')

    <!-- Page Specific Script Stack -->
    @stack('scripts')
</body>

</html>

