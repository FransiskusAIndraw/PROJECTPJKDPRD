@extends('layouts.app')
@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Surat Masuk untuk Anda</h2>

    <table class="table-auto w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">No Surat</th>
                <th class="px-4 py-2">Asal Surat</th>
                <th class="px-4 py-2">Tanggal</th>
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
                <td class="px-4 py-2">
                    <a href="{{ route('staff.surat.show', $surat->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-3">Belum ada surat untuk Anda</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
