@extends('layouts.tusekwan')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Detail Surat Masuk</h2>

    <div class="mb-4">
        <p><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</p>
        <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>
        <p><strong>Asal Surat:</strong> {{ $surat->asal_surat }}</p>
        <p><strong>Tanggal Surat:</strong> {{ $surat->tanggal_surat }}</p>
        <p><strong>Status Saat Ini:</strong>
            <span class="px-2 py-1 rounded text-white
                @if($surat->status_screening == 'approved') bg-green-500
                @elseif($surat->status_screening == 'rejected') bg-red-500
                @else bg-yellow-500
                @endif">
                {{ ucfirst($surat->status_screening) }}
            </span>
        </p>
    </div>

    <hr class="my-4">

    <h3 class="text-lg font-semibold mb-2">Perbarui Status Screening</h3>

    <form action="{{ route('tusekwan.screening.update', $surat->id) }}" method="POST">
        @method('PATCH')
        @include('tusekwan.screening.form', ['surat' => $surat])
    </form>
</div>
@endsection
