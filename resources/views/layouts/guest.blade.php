<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SEKRETARIAT DPRD</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #06008A; /* background biru gelap */
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">

<div class="min-h-screen flex items-center justify-center px-4">

    <!-- Container tempat form login ditampilkan -->
    {{ $slot }}

</div>

</body>
</html>
