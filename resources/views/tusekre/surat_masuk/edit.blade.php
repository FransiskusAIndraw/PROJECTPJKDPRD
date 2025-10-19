@extends('layouts.app')
@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Surat Masuk</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('tusekre.surat_masuk.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Surat
    </a>

    <table class="table-auto w-full mt-4 border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">No Surat</th>
                <th class="px-4 py-2">Asal Surat</th>
                <th class="px-4 py-2">Tanggal Diterima</th>
                <th class="px-4 py-2">Status Screening</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($surats as $surat)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $surat->no_surat }}</td>
                <td class="px-4 py-2">{{ $surat->asal_surat }}</td>
                <td class="px-4 py-2">{{ $surat->tanggal_diterima }}</td>
                <td class="px-4 py-2 capitalize">{{ $surat->status_screening }}</td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('tusekre.surat_masuk.show', $surat->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                    <a href="{{ route('tusekre.surat_masuk.edit', $surat->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-3">Belum ada surat masuk</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
