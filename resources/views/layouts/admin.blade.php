<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#004AAD] text-white flex flex-col">
        <div class="w-full bg-[#004AAD] border-b border-blue-800">
        <div class="px-4 py-3">
            <div class="flex items-center gap-3">
                {{-- Logo bulat --}}
                <div class="flex-shrink-0">
                    <img
                        src="{{ asset('images/logo.jpg') }}"
                        alt="Logo DPRD"
                        class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover"
                    />
                </div>

                {{-- Teks judul --}}
                <div class="text-white leading-tight">
                    <div class="text-sm font-semibold">SISTEM SURAT MASUK</div>
                    <div class="text-sm font-semibold">DAN DISPOSISI SURAT</div>
                </div>

                <div class="ml-auto"></div>
            </div>
        </div>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <!-- Cek apakah route ini aktif -->
            <a href="{{ route('admin.dashboard') }}" 
               class="block hover:bg-blue-700 rounded p-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-900 text-white font-semibold' : 'hover:bg-blue-600' }}">
               Dashboard
            </a>
            <a href="{{ route('admin.kelola_pengguna') }}" 
               class="block hover:bg-blue-700 rounded p-2 {{ request()->routeIs('admin.kelola_pengguna') ? 'bg-blue-900 text-white font-semibold' : 'hover:bg-blue-600' }}">
               Kelola Pengguna
            </a>
            <a href="{{ route('admin.penambahan_akun') }}" 
               class="block hover:bg-blue-700 rounded p-2 {{ request()->routeIs('admin.penambahan_akun') ? 'bg-blue-900 text-white font-semibold' : 'hover:bg-blue-600' }}">
               Penambahan Akun
            </a>
        </nav>
        <div class="p-4 border-t border-blue-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-blue-600 rounded p-2">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-5 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Admin Dashboard | {{ Auth::user()->name }}</h1>
            <x-notif-bell />
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
