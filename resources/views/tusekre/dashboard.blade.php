@extends('layouts.tusekre')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600">Anda login sebagai <strong>TU Sekretariat</strong>.</p>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">Aktivitas Terbaru</h3>
        <ul class="space-y-2">
            <li>📩 Surat Masuk baru diunggah</li>
            <li>✅ Surat telah dikirim ke TU Sekwan</li>
            <li>📤 Arsip surat selesai dibuat</li>
        </ul>
    </div>
</div>
@endsection
