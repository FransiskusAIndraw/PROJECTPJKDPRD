@extends('layouts.app')

@section('title', 'Dashboard TU Sekwan')

@section('content')
<div class="container mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-6">Dashboard TU Sekwan</h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-300 rounded p-3 mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Total Surat Masuk</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-yellow-50 shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Pending Screening</h2>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] ?? 0 }}</p>
        </div>
        <div class="bg-green-50 shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Approved</h2>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['approved'] ?? 0 }}</p>
        </div>
        <div class="bg-red-50 shadow rounded-xl p-4">
            <h2 class="text-gray-500 text-sm">Rejected</h2>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['rejected'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Recent Surat --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Surat Terbaru</h2>
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">No Surat</th>
                    <th class="px-4 py-2 text-left">Pengirim</th>
                    <th class="px-4 py-2 text-left">Perihal</th>
                    <th class="px-4 py-2 text-left">Status Screening</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
                @forelse($recentSurat as $surat)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $surat->nomor_surat }}</td>
                        <td class="px-4 py-2">{{ $surat->pengirim }}</td>
                        <td class="px-4 py-2">{{ $surat->perihal }}</td>
                        <td class="px-4 py-2">
                            @if($surat->status_screening == 'pending')
                                <span class="text-yellow-600 font-medium">Pending</span>
                            @elseif($surat->status_screening == 'approved')
                                <span class="text-green-600 font-medium">Approved</span>
                            @else
                                <span class="text-red-600 font-medium">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $surat->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada surat masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
