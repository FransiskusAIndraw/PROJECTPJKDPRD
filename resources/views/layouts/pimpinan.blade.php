<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pimpinan Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-screen">
    <aside class="w-64 bg-green-700 text-white flex flex-col">
        <div class="p-4 text-lg font-semibold border-b border-green-500">Pimpinan</div>
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li><a href="{{ route('pimpinan.dashboard') }}" class="block hover:bg-green-600 rounded p-2">Dashboard</a></li>
               {{-- <li><a href="{{ route('pimpinan.disposisi.index') }}" class="block hover:bg-green-600 rounded p-2">Disposisi</a></li> --}}
            </ul>
        </nav>
        <div class="p-4 border-t border-green-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-green-600 rounded p-2">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-4 flex justify-between">
            <h1 class="text-lg font-semibold">Dashboard Pimpinan</h1>
            <span>{{ Auth::user()->name }}</span>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
