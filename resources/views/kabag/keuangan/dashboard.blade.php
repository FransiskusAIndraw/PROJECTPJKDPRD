@extends('layouts.kabag')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-emerald-700 mb-4">Dashboard Kabag Keuangan</h2>
    <p class="text-gray-700">
        Selamat datang, {{ Auth::user()->name }}!  
        Ini adalah halaman utama untuk <strong>Kabag Keuangan</strong>.  
        Gunakan menu di sidebar untuk melihat dan memproses disposisi surat.
    </p>
</div>
@endsection
