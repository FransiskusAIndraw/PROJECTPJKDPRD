@extends('layouts.tusekwan')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600">Anda login sebagai <strong>TU Sekwan</strong>.</p>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">Surat untuk Discreening</h3>
        <p>Anda memiliki <span class="text-blue-600 font-bold">5</span> surat yang menunggu proses screening.</p>
        <a href="{{ route('tusekwan.screening.index') }}" class="inline-block mt-3 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Lihat Screening</a>
    </div>
</div>
@endsection
