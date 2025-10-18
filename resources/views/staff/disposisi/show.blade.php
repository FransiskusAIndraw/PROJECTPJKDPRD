@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Detail Disposisi</h1>
        <a href="{{ route('staff.disposisi.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-2">Informasi Surat</h2>
        <p><strong>Nomor Surat:</strong> {{ $disposisi->suratMasuk->nomor_surat }}</p>
        <p><strong>Perihal:</strong> {{ $disposisi->suratMasuk->perihal }}</p>
        <p><strong>Dari:</strong> {{ $disposisi->suratMasuk->asal_surat }}</p>
        <p><strong>Tanggal Masuk:</strong> {{ $disposisi->suratMasuk->tanggal_masuk }}</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-2">Catatan Disposisi</h2>
        <p>{{ $disposisi->catatan ?? '-' }}</p>
        <p class="mt-2 text-sm text-gray-500">Diteruskan oleh: {{ $disposisi->user->name }}</p>
    </div>

    @if ($disposisi->status !== 'selesai')
        <form method="POST" action="{{ route('staff.disposisi.updateStatus', $disposisi->id) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Tandai Selesai
            </button>
        </form>
    @else
        <div class="bg-green-100 text-green-700 p-3 rounded-lg">
            Disposisi ini sudah ditandai selesai.
        </div>
    @endif
</div>
@endsection
