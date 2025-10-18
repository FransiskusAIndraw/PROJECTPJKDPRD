@extends('layouts.tusekwan')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-4">Daftar Surat Masuk untuk Screening</h2>

    <table class="min-w-full border border-gray-300 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Nomor Surat</th>
                <th class="px-4 py-2 text-left">Perihal</th>
                <th class="px-4 py-2 text-left">Asal Surat</th>
                <th class="px-4 py-2 text-left">Tanggal</th>
                <th class="px-4 py-2 text-left">Status Screening</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suratMasuk as $surat)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $surat->nomor_surat }}</td>
                    <td class="px-4 py-2">{{ $surat->perihal }}</td>
                    <td class="px-4 py-2">{{ $surat->asal_surat }}</td>
                    <td class="px-4 py-2">{{ $surat->tanggal_surat }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-white text-sm
                            @if($surat->status_screening == 'approved') bg-green-500
                            @elseif($surat->status_screening == 'rejected') bg-red-500
                            @else bg-yellow-500
                            @endif">
                            {{ ucfirst($surat->status_screening) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('tusekwan.screening.show', $surat->id) }}"
                           class="text-blue-600 hover:underline">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                        Tidak ada surat masuk untuk discreening.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
