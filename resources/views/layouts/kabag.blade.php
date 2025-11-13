<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabag Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

@php
    $role = Auth::user()->roles ?? 'kabag';
    $namaBidang = [
        'kabag_keuangan' => 'Keuangan',
        'kabag_persidangan' => 'Persidangan',
        'kabag_umum' => 'Umum',
    ][$role] ?? 'Kabag';
@endphp

<body class="bg-gray-100 flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#004AAD] text-white flex flex-col">
        {{-- Header sidebar: logo + judul --}}
        <div class="w-full bg-[#004AAD] border-b border-blue-800">
            <div class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <img
                            src="{{ asset('images/logo.jpg') }}"
                            alt="Logo DPRD"
                            class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover"
                        />
                    </div>
                    <div class="text-white leading-tight">
                        <div class="text-sm font-semibold">SISTEM SURAT MASUK</div>
                        <div class="text-sm font-semibold">DAN DISPOSISI SURAT</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('kabag.' . strtolower($namaBidang) . '.dashboard') }}" 
               class="block rounded p-2 hover:bg-blue-700 {{ request()->routeIs('kabag.' . strtolower($namaBidang) . '.dashboard') ? 'bg-blue-900' : '' }}">
               Dashboard
            </a>

            <a href="{{ route('kabag.' . strtolower($namaBidang) . '.disposisi.index') }}" 
               class="block rounded p-2 hover:bg-blue-700 {{ request()->routeIs('kabag.' . strtolower($namaBidang) . '.disposisi.index') ? 'bg-blue-900' : '' }}">
               Daftar Disposisi
            </a>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-blue-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-blue-700 rounded p-2">
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
            <x-notif-bell />
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
