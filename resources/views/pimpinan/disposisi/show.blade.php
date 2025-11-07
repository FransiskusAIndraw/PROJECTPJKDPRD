@extends('layouts.pimpinan')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-4">Detail Disposisi Surat</h2>

    <p><strong>Nomor Surat:</strong> {{ $disposisi->surat->nomor_surat }}</p>
    <p><strong>Perihal:</strong> {{ $disposisi->surat->perihal }}</p>
    <p><strong>Asal Surat:</strong> {{ $disposisi->surat->pengirim }}</p>
    <p><strong>Diteruskan Kepada:</strong> {{ $disposisi->kepada->name }}</p>
    <p><strong>Instruksi:</strong> {{ $disposisi->instruksi }}</p>
    <p><strong>Status:</strong> <span class="capitalize">{{ $disposisi->status_dispo }}</span></p>

    <div class="mt-4 flex gap-2">
        @if($disposisi->status_dispo !== 'selesai')
        <form action="{{ route('pimpinan.disposisi.update', $disposisi->id) }}" method="POST">
            @csrf @method('PUT')
            <button class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                Tandai Selesai
            </button>
        </form>
        @endif

        <a href="{{ route('pimpinan.disposisi.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            Kembali
        </a>
    </div>

</div>
@endsection
