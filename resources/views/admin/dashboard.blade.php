@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600">Anda login sebagai <strong>Administrator</strong>.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">Total Pengguna</h3>
            <p class="text-3xl font-bold text-blue-600">45</p>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">Surat Masuk</h3>
            <p class="text-3xl font-bold text-green-600">132</p>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">Disposisi Aktif</h3>
            <p class="text-3xl font-bold text-yellow-600">27</p>
        </div>
    </div>
</div>
@endsection
