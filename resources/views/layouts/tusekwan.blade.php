<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TU Sekwan Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-screen">
    <aside class="w-64 bg-purple-700 text-white flex flex-col">
        <div class="p-4 text-lg font-semibold border-b border-purple-500">TU Sekwan</div>
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li><a href="{{ route('tusekwan.dashboard') }}" class="block hover:bg-purple-600 rounded p-2">Dashboard</a></li>
                <li><a href="{{ route('tusekwan.screening.index') }}" class="block hover:bg-purple-600 rounded p-2">Screening Surat</a></li>
                <li><a href="{{ route('tusekwan.surat_masuk.index') }}" class="block hover:bg-purple-600 rounded p-2">Surat Masuk</a></li>
            </ul>
        </nav>
        <div class="p-4 border-t border-purple-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-purple-600 rounded p-2">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-4 flex justify-between">
            <h1 class="text-lg font-semibold">Dashboard TU Sekwan</h1>
            <span>{{ Auth::user()->name }}</span>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
