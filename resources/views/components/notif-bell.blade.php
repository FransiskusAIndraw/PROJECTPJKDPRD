@php
    use App\Models\Notifikasi;
    $notifs = Auth::user()->notifikasi()->where('status_notif', 'belum_terbaca')->latest()->take(10)->get();
    $count = $notifs->count();
@endphp

<div x-data="{ open: false }" class="relative">

    <button @click="open = !open" class="relative">
        <i class="bi bi-bell text-2xl"></i>
        @if($count > 0)
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1">{{ $count }}</span>
        @endif
    </button>

    <div x-show="open" @click.outside="open = false"
         class="absolute right-0 mt-2 w-72 bg-white shadow-lg border rounded-lg z-50">

        <div class="p-3 border-b font-semibold">Notifikasi</div>

        @forelse($notifs as $notif)
            <form method="POST" action="{{ route('notifikasi.read', $notif->id) }}">
                @csrf
                <button class="w-full text-left p-3 border-b hover:bg-gray-100 text-sm">
                    {{ $notif->pesan }}
                    <div class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</div>
                </button>
            </form>
        @empty
            <div class="p-3 text-sm text-gray-500">Tidak ada notifikasi baru</div>
        @endforelse

        <div class="text-center p-2 border-t">
            <form method="POST" action="{{ route('notifikasi.readAll') }}">
                @csrf
                <button class="text-blue-600 text-sm">Tandai semua terbaca</button>
            </form>
        </div>

    </div>
</div>
