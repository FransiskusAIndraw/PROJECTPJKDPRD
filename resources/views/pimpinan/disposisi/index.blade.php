@extends('layouts.pimpinan')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-4">Surat Masuk untuk Ditinjau</h2>

    <table class="w-full border border-gray-200">
        <thead class="bg-purple-700 text-white">
            <tr>
                <th class="p-2 text-left">Nomor Surat</th>
                <th class="p-2 text-left">Perihal</th>
                <th class="p-2 text-left">Pengirim</th>
                <th class="p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratMasuk as $surat)
            <tr class="border-b hover:bg-gray-100">
                <td class="p-2">{{ $surat->nomor_surat }}</td>
                <td class="p-2">{{ $surat->perihal }}</td>
                <td class="p-2">{{ $surat->pengirim }}</td>
                <td class="p-2">
                    <a href="{{ route('pimpinan.disposisi.review', $surat->id) }}" class="text-blue-600 underline">
                        Tambahkan Instruksi
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
