@extends('layouts.tusekre')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600 mb-8">Anda login sebagai <strong>TU Sekretariat</strong>.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-dashboard-card title="Surat Masuk" color="text-blue-600" :count="$suratMasuk" />
        <x-dashboard-card title="Surat yang Sudah Diarsip" color="text-green-600" :count="$suratArsip" />
        <x-dashboard-card title="Surat yang Perlu Direvisi" color="text-red-600" :count="$suratRevisi" />
    </div>
</div>
@endsection
