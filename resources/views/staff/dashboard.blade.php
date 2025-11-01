@extends('layouts.staff')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600">Anda login sebagai <strong>Staff</strong>.</p>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">Surat yang Diterima</h3>
        <p>Anda memiliki <span class="text-blue-600 font-bold">3</span> surat yang belum ditindaklanjuti.</p>
        <a href="{{ route('staff.surat.index') }}" class="inline-block mt-3 px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Lihat Surat</a>
    </div>
</div>
@endsection
