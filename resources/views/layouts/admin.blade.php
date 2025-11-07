<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-lg font-semibold border-b border-gray-700">
            Panel Admin
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <!-- Cek apakah route ini aktif -->
            <a href="{{ route('admin.dashboard') }}" 
               class="block hover:bg-gray-700 rounded p-2 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : '' }}">
               Dashboard
            </a>
            <a href="{{ route('admin.kelola_pengguna') }}" 
               class="block hover:bg-gray-700 rounded p-2 {{ request()->routeIs('admin.kelola_pengguna') ? 'bg-gray-900' : '' }}">
               Kelola Pengguna
            </a>
            <a href="{{ route('admin.penambahan_akun') }}" 
               class="block hover:bg-gray-700 rounded p-2 {{ request()->routeIs('admin.penambahan_akun') ? 'bg-gray-900' : '' }}">
               Penambahan Akun
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-gray-700 rounded p-2">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Admin Dashboard | {{ Auth::user()->name }}</h1>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
