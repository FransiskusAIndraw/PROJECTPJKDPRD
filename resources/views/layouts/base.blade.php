<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DPRD Disposisi System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex">
    {{-- Sidebar --}}
    <aside class="w-64 bg-blue-900 text-white p-4">
        @yield('sidebar')
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        <header class="mb-6 border-b pb-2">
            <h1 class="text-2xl font-bold">@yield('title', 'Dashboard')</h1>
        </header>

        <section>
            @yield('content')
        </section>
    </main>
</body>
</html>
