@extends('layouts.app')
@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Detail Surat Masuk</h2>

    <div class="border rounded p-4 space-y-3">
        <p><strong>No Surat:</strong> {{ $surat->no_surat }}</p>
        <p><strong>Asal Surat:</strong> {{ $surat->asal_surat }}</p>
        <p><strong>Tanggal Diterima:</strong> {{ $surat->tanggal_diterima }}</p>
        <p><strong>Status Screening:</strong> {{ ucfirst($surat->status_screening) }}</p>
        <p><strong>Catatan Screening:</strong> {{ $surat->catatan_screening ?? '-' }}</p>

        @if($surat->file_surat)
            <p><strong>File:</strong> <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a></p>
        @endif
    </div>

    <a href="{{ route('tusekre.surat_masuk.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">← Kembali</a>
</div>
@endsection
