@extends('layouts.tusekre')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Arsip Surat Masuk</h2>

    <!-- Filter Periode -->
    <form method="GET" action="{{ route('tusekre.arsip_surat.index') }}" class="flex flex-wrap items-center gap-3 mb-6">
        <label for="periode" class="font-medium">Periode:</label>
        <select name="periode" id="periode" class="border border-gray-300 rounded p-2">
            <option value="all" {{ request('periode') == 'all' ? 'selected' : '' }}>Semua</option>
            <option value="1_week" {{ request('periode') == '1_week' ? 'selected' : '' }}>1 Minggu Terakhir</option>
            <option value="1_month" {{ request('periode') == '1_month' ? 'selected' : '' }}>1 Bulan Terakhir</option>
            <option value="3_months" {{ request('periode') == '3_months' ? 'selected' : '' }}>3 Bulan Terakhir</option>
            <option value="6_months" {{ request('periode') == '6_months' ? 'selected' : '' }}>6 Bulan Terakhir</option>
            <option value="1_year" {{ request('periode') == '1_year' ? 'selected' : '' }}>1 Tahun Terakhir</option>
        </select>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Filter
        </button>

        <!-- Tombol Ekspor -->
        <a href="{{ route('tusekre.arsip_surat.export', ['periode' => request('periode', 'all')]) }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            Export ke Excel
        </a>
    </form>

    <!-- Tabel Surat -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Nomor Surat</th>
                    <th class="px-4 py-2 text-left">Perihal</th>
                    <th class="px-4 py-2 text-left">Tanggal Surat</th>
                    <th class="px-4 py-2 text-left">Asal Surat</th>
                    <th class="px-4 py-2 text-left">File</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratMasuk as $surat)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $surat->nomor_surat }}</td>
                    <td class="px-4 py-2">{{ $surat->perihal }}</td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-2">{{ $surat->pengirim }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank"
                           class="text-blue-700 hover:underline">Lihat File</a>
                    </td>
                    <td class="px-4 py-2">
                        @if ($surat->status === 'draft')
                            <form action="{{ route('tusekre.arsip_surat.arsipkan', $surat->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Arsipkan
                                </button>
                            </form>
                        @else
                            <span class="text-gray-600 italic">{{ \App\Models\SuratMasuk::statusLabel($surat->status) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">
                        Tidak ada surat ditemukan untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $suratMasuk->links() }}
    </div>
</div>
@endsection
