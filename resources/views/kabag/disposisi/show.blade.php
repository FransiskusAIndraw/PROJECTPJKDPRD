@extends('layouts.kabag')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-3xl">
    <h2 class="text-xl font-semibold mb-4">Detail Disposisi</h2>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="border rounded p-4">
            <div class="text-sm text-gray-600">Nomor Surat</div>
            <div class="font-medium">{{ $disposisi->surat->nomor_surat }}</div>
        </div>
        <div class="border rounded p-4">
            <div class="text-sm text-gray-600">Tanggal Surat</div>
            <div class="font-medium">{{ optional($disposisi->surat->tanggal_surat)->format('d M Y') }}</div>
        </div>
        <div class="border rounded p-4 col-span-2">
            <div class="text-sm text-gray-600">Perihal</div>
            <div class="font-medium">{{ $disposisi->surat->perihal }}</div>
        </div>
        <div class="border rounded p-4 col-span-2">
            <div class="text-sm text-gray-600">Instruksi (riwayat)</div>
            <div class="whitespace-pre-line text-sm text-gray-800 mt-2">{{ $disposisi->instruksi }}</div>
        </div>
    </div>

    <div class="flex gap-2">
        <form action="{{ route('kabag.' . (Auth::user()->roles === 'kabag_keuangan' ? 'keuangan' : (Auth::user()->roles === 'kabag_persidangan' ? 'persidangan' : 'umum')) . '.disposisi.selesai', $disposisi->id) }}"
              method="POST" onsubmit="return confirm('Tandai selesai dan arsipkan surat?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded">Tandai Selesai & Arsip</button>
        </form>

        <a href="{{ route('kabag.' . (Auth::user()->roles === 'kabag_keuangan' ? 'keuangan' : (Auth::user()->roles === 'kabag_persidangan' ? 'persidangan' : 'umum')) . '.disposisi.index') }}"
           class="px-4 py-2 bg-gray-200 rounded">Kembali</a>
    </div>
</div>
@endsection
