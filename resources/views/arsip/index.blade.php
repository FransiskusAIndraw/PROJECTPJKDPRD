@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Arsip Surat Masuk</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($arsipSurat->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded-lg">
            Belum ada surat yang diarsipkan.
        </div>
    @else
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Nomor Surat</th>
                        <th class="px-4 py-2 text-left">Perihal</th>
                        <th class="px-4 py-2 text-left">Asal Surat</th>
                        <th class="px-4 py-2 text-left">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($arsipSurat as $surat)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $surat->nomor_surat }}</td>
                            <td class="px-4 py-2">{{ $surat->perihal }}</td>
                            <td class="px-4 py-2">{{ $surat->asal_surat }}</td>
                            <td class="px-4 py-2">{{ $surat->tanggal_masuk }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
