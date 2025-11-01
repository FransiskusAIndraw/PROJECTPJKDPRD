<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-screen">
    <aside class="w-64 bg-orange-700 text-white flex flex-col">
        <div class="p-4 text-lg font-semibold border-b border-orange-500">Staff</div>
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li><a href="{{ route('staff.dashboard') }}" class="block hover:bg-orange-600 rounded p-2">Dashboard</a></li>
                <li><a href="{{ route('staff.surat.index') }}" class="block hover:bg-orange-600 rounded p-2">Surat Tugas</a></li>
            </ul>
        </nav>
        <div class="p-4 border-t border-orange-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left hover:bg-orange-600 rounded p-2">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-4 flex justify-between">
            <h1 class="text-lg font-semibold">Dashboard Staff</h1>
            <span>{{ Auth::user()->name }}</span>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
