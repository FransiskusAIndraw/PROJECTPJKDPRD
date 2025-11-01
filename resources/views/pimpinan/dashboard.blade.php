@extends('layouts.pimpinan')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600">Anda login sebagai <strong>Pimpinan DPRD</strong>.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">Disposisi Aktif</h3>
            <p class="text-3xl font-bold text-green-600">8</p>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">Surat Selesai</h3>
            <p class="text-3xl font-bold text-blue-600">12</p>
        </div>
    </div>

    {{-- <a href="{{ route('pimpinan.disposisi.index') }}" class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Kelola Disposisi</a> --}}
</div>
@endsection
