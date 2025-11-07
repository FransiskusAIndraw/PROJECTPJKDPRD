@extends('layouts.tusekwan')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Cari Surat Masuk</h2>

    <form action="{{ route('tusekwan.surat_masuk.search') }}" method="GET" class="mb-4 flex gap-2">
        <input type="text" name="q" class="border rounded p-2 w-full"
               placeholder="Cari nomor surat, perihal, atau pengirim..."
               value="{{ $query ?? '' }}">

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Cari
        </button>
    </form>

    <table class="w-full border border-gray-200">
        <thead class="bg-blue-700 text-white">
            <tr>
                <th class="p-2 text-left">ID</th>
                <th class="p-2 text-left">Nomor Surat</th>
                <th class="p-2 text-left">Perihal</th>
                <th class="p-2 text-left">Pengirim</th>
                <th class="p-2 text-left">Tanggal</th>
                <th class="p-2 text-left">File</th>
            </tr>
        </thead>

        <tbody>
        @forelse($suratMasuk as $surat)
            <tr class="border-b hover:bg-gray-100">
                <td class="p-2">{{ $surat->id }}</td>
                <td class="p-2">{{ $surat->nomor_surat }}</td>
                <td class="p-2">{{ $surat->perihal }}</td>
                <td class="p-2">{{ $surat->pengirim }}</td>
                <td class="p-2">{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                <td class="p-2">
                    <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500 p-4">Tidak ditemukan...</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $suratMasuk->appends(['q' => $query])->links() }}
    </div>
</div>
@endsection