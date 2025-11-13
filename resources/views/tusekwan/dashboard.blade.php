@extends('layouts.tusekwan')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600 mb-8">Anda login sebagai <strong>TU Sekwan</strong>.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-dashboard-card title="Surat Perlu Validasi" color="text-blue-600" :count="$suratValidasi" />
        <x-dashboard-card title="Disposisi Aktif" color="text-green-600" :count="$disposisiAktif" />
        <x-dashboard-card title="Disposisi Selesai" color="text-red-600" :count="$disposisiSelesai" />
    </div>
</div>
@endsection
