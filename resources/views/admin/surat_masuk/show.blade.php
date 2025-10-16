@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detail Surat Masuk</h1>
    <div class="bg-white shadow-md rounded p-4">
        <p><strong>No Surat:</strong> {{ $surat->no_surat }}</p>
        <p><strong>Pengirim:</strong> {{ $surat->pengirim }}</p>
        <p><strong>Tanggal Surat:</strong> {{ $surat->tgl_surat->format('d-m-Y') }}</p>
        <p><strong>Status:</strong> {{ $surat->status_surat }}</p>
        @if($surat->file_surat)
        <p><strong>File Surat:</strong> <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank">Lihat File</a></p>
        @endif
    </div>
</div>
@endsection
