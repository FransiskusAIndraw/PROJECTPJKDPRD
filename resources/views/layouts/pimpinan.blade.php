<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pimpinan Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen">
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

                {{-- ruang kosong kanan (bisa diisi ikon/lonceng jika perlu) --}}
                <div class="ml-auto"></div>
            </div>
        </div>
        </div>
    <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('pimpinan.dashboard') }}" 
                    class="block rounded p-2 {{ request()->routeIs('pimpinan.dashboard') ? 'bg-blue-900 text-white font-semibold' : 'hover:bg-blue-600' }}">
                    Dashboard
                    </a>
                </li>
               <li>
                    <a href="{{ route('pimpinan.disposisi.index') }}" 
                    class="block rounded p-2 {{ request()->routeIs('pimpinan.disposisi.index') ? 'bg-blue-900 text-white font-semibold' : 'hover:bg-blue-600' }}">
                    Disposisi Surat
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-blue-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-blue-600 rounded p-2">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-5 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Dashboard Pimpinan | {{ Auth::user()->name }}</h1>

            <x-notif-bell />
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
