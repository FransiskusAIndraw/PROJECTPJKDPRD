<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TU Sekretariat Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-700 text-white flex flex-col">
        <div class="p-4 text-lg font-semibold border-b border-blue-500">
            Panel TU Sekretariat
        </div>

        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('tusekre.dashboard') }}"
                       class="block rounded p-2 {{ request()->routeIs('tusekre.dashboard') ? 'bg-blue-800 text-white font-semibold' : 'hover:bg-blue-600' }}">
                        Dashboard
                    </a>
                </li>

                <!-- Input Surat Masuk -->
                <li>
                    <a href="{{ route('tusekre.surat_masuk.index') }}"
                       class="block rounded p-2 {{ request()->routeIs('tusekre.surat_masuk.index') ? 'bg-blue-800 text-white font-semibold' : 'hover:bg-blue-600' }}">
                        Input Surat Masuk
                    </a>
                </li>

                <!-- Revisi Surat -->
                <li>
                    <a href="{{ route('tusekre.surat_perlu_revisi') }}"
                        class="block rounded p-2 {{ request()->routeIs('tusekre.surat_perlu_revisi') ? 'bg-blue-800 text-white font-semibold' : 'hover:bg-blue-600' }}">
                        Surat Perlu Revisi
                    </a>
                </li>

                <!-- Pencarian Surat -->
                <li>
                    <a href="{{ route('tusekre.surat_masuk.search') }}"
                       class="block rounded p-2 {{ request()->routeIs('tusekre.surat_masuk.search') ? 'bg-blue-800 text-white font-semibold' : 'hover:bg-blue-600' }}">
                        Pencarian Surat
                    </a>
                </li>

                <!-- Arsip Surat -->
                <li>
                    <a href="{{ route('tusekre.arsip_surat.index') }}" 
                        class="block rounded p-2 {{ request()->routeIs('tusekre.arsip_surat.*') ? 'bg-blue-800 text-white font-semibold' : 'hover:bg-blue-600' }}">
                        Arsip Surat
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-blue-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-blue-600 rounded p-2">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">TU Sekretariat | {{ Auth::user()->name }}</h1>

            <x-notif-bell />
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
