<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TU Sekretariat Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-700 text-white flex flex-col">
        <div class="p-4 text-lg font-semibold border-b border-blue-500">TU Sekretariat</div>
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li><a href="{{ route('tusekre.dashboard') }}" class="block hover:bg-blue-600 rounded p-2">Dashboard</a></li>
                <li><a href="{{ route('tusekre.surat_masuk.index') }}" class="block hover:bg-blue-600 rounded p-2">Surat Masuk</a></li>
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
        <header class="bg-white shadow p-4 flex justify-between">
            <h1 class="text-lg font-semibold">Dashboard TU Sekretariat</h1>
            <span>{{ Auth::user()->name }}</span>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
