@extends('layouts.tusekre')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Verifikasi dan Validasi Surat Masuk</h2>

    <!-- Pencarian -->
    <div class="flex justify-between items-center mb-6">
        <input type="text" id="searchInput" placeholder="Cari Surat..." class="border border-gray-300 rounded p-2 w-1/3" />
    </div>

    <!-- Tabel Surat -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Nomor Surat</th>
                    <th class="px-4 py-2 text-left">Perihal Surat</th>
                    <th class="px-4 py-2 text-left">Tanggal Surat</th>
                    <th class="px-4 py-2 text-left">Asal Surat</th>
                    <th class="px-4 py-2 text-left">File Surat</th>
                    <th class="px-4 py-2 text-left">Status Surat</th>
                    <th class="px-4 py-2 text-left">Revisi Surat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratMasuk as $surat)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $surat->nomor_surat }}</td>
                    <td class="px-4 py-2">{{ $surat->perihal }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $surat->pengirim }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ asset('storage/' . $surat->file_surat) }}" 
                           target="_blank" class="text-blue-700 hover:underline">
                            Lihat File
                        </a>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('tusekre.verifikasi.kirim', $surat->id) }}" 
                           class="text-green-600 font-semibold hover:underline">Kirim</a> /
                        <a href="{{ route('tusekre.verifikasi.tolak', $surat->id) }}" 
                           class="text-red-600 font-semibold hover:underline">Tolak</a>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('tusekre.surat_masuk.edit', $surat->id) }}" 
                           class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">
                        Tidak ada surat untuk diverifikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
