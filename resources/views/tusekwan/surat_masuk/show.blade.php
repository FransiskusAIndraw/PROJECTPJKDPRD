@extends('layouts.tusekwan')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Detail Surat Masuk</h2>

    <div class="bg-white shadow rounded p-4 mb-6">
        <p><strong>No. Surat:</strong> {{ $surat->nomor_surat }}</p>
        <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>
        <p><strong>Asal Surat:</strong> {{ $surat->asal_surat }}</p>
        <p><strong>Tanggal Masuk:</strong> {{ $surat->tanggal_masuk }}</p>
        <p><strong>Status:</strong> {{ ucfirst($surat->status) }}</p>
        <p><strong>Isi Surat:</strong></p>
        <p class="border p-2 rounded bg-gray-50">{{ $surat->isi_ringkas }}</p>
    </div>

    <div class="flex space-x-3">
        <a href="{{ route('tusekwan.surat_masuk.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            ← Kembali
        </a>
    </div>
</div>
@endsection
