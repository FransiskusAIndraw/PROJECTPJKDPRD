<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabag Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $role = Auth::user()->roles ?? 'kabag';
    $warna = [
        'kabag_keuangan' => 'blue',
        'kabag_persidangan' => 'red',
        'kabag_umum' => 'green',
    ][$role] ?? 'gray';

    $namaBidang = [
        'kabag_keuangan' => 'Keuangan',
        'kabag_persidangan' => 'Persidangan',
        'kabag_umum' => 'Umum',
    ][$role] ?? 'Kabag';
@endphp
<body class="bg-gray-100 flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-{{ $warna }}-800 text-white flex flex-col">
        <div class="p-4 text-lg font-semibold border-b border-{{ $warna }}-700">
            Kabag {{ $namaBidang }}
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('kabag.' . strtolower($namaBidang) . '.dashboard') }}" 
               class="block hover:bg-{{ $warna }}-700 rounded p-2 {{ request()->routeIs('kabag.' . strtolower($namaBidang) . '.dashboard') ? 'bg-' . $warna . '-900' : '' }}">
               Dashboard
            </a>

            <a href="{{ route('kabag.' . strtolower($namaBidang) . '.disposisi.index') }}" 
               class="block hover:bg-{{ $warna }}-700 rounded p-2 {{ request()->routeIs('kabag.' . strtolower($namaBidang) . '.disposisi.index') ? 'bg-' . $warna . '-900' : '' }}">
               Daftar Disposisi
            </a>
        </nav>

        <div class="p-4 border-t border-{{ $warna }}-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-{{ $warna }}-700 rounded p-2">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">
                Dashboard Kabag {{ $namaBidang }} | {{ Auth::user()->name }}
            </h1>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
