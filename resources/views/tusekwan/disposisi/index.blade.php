@extends('layouts.tusekwan')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-4">Disposisi Surat</h2>

    {{-- SURAT UNTUK DIKIRIM KE PIMPINAN --}}
    <h3 class="font-semibold mb-2 text-purple-700">Surat Siap Didisposisikan ke Pimpinan</h3>

    <table class="w-full border border-gray-200 mb-8">
        <thead class="bg-purple-700 text-white">
            <tr>
                <th class="p-2">Nomor Surat</th>
                <th class="p-2">Perihal</th>
                <th class="p-2">Pengirim</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratUntukPimpinan as $surat)
            <tr class="border-b hover:bg-gray-100">
                <td class="p-2">{{ $surat->nomor_surat }}</td>
                <td class="p-2">{{ $surat->perihal }}</td>
                <td class="p-2">{{ $surat->pengirim }}</td>
                <td class="p-2">
                    <a href="{{ route('tusekwan.disposisi.create', $surat->id) }}"
                       class="text-blue-600 underline">Buat Disposisi</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-3 text-gray-500">Tidak ada surat.</td></tr>
            @endforelse
        </tbody>
    </table>


    {{-- SURAT DARI PIMPINAN (SIAP FINALISASI) --}}
    <h3 class="font-semibold mb-2 text-green-700">Surat Telah Dikembalikan Pimpinan (Siap Finalisasi)</h3>

    <table class="w-full border border-gray-200">
        <thead class="bg-green-700 text-white">
            <tr>
                <th class="p-2">Nomor Surat</th>
                <th class="p-2">Perihal</th>
                <th class="p-2">Pengirim</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratDariPimpinan as $surat)
            <tr class="border-b hover:bg-gray-100">
                <td class="p-2">{{ $surat->nomor_surat }}</td>
                <td class="p-2">{{ $surat->perihal }}</td>
                <td class="p-2">{{ $surat->pengirim }}</td>
                <td class="p-2">
                    <a href="{{ route('tusekwan.disposisi.finalForm', $surat->id) }}"
                       class="text-indigo-700 underline font-semibold">Finalisasi</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-3 text-gray-500">Belum ada surat.</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
