@extends('layouts.tusekre')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Pencarian Surat Masuk</h2>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form pencarian --}}
    <form method="GET" action="{{ route('tusekre.surat_masuk.search') }}" class="flex flex-wrap gap-3 mb-4">
        <div class="flex-grow">
            <input 
                type="text" 
                name="q" 
                value="{{ $query ?? '' }}" 
                placeholder="Cari berdasarkan nomor, perihal, atau pengirim..." 
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <div>
            <select name="per_page" onchange="this.form.submit()" class="border border-gray-300 rounded-md p-2">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            </select>
        </div>

        <button 
            type="submit" 
            class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
        >
            Cari
        </button>
    </form>

    {{-- Tabel hasil pencarian --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-md">
            <thead class="bg-blue-700 text-white">
                <tr class="text-left">
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Nomor Surat</th>
                    <th class="px-4 py-2 border-b">Perihal</th>
                    <th class="px-4 py-2 border-b">Tanggal Surat</th>
                    <th class="px-4 py-2 border-b">Asal Surat</th>
                    <th class="px-4 py-2 border-b text-center">File</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratMasuk as $surat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $surat->id }}</td>
                        <td class="px-4 py-2 border-b">{{ $surat->nomor_surat }}</td>
                        <td class="px-4 py-2 border-b">{{ $surat->perihal }}</td>
                        <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border-b">{{ $surat->pengirim }}</td>
                        <td class="px-4 py-2 border-b text-center">
                            @if($surat->file_surat)
                                <a href="{{ asset('storage/'.$surat->file_surat) }}" 
                                   target="_blank" 
                                   class="text-blue-600 hover:underline">
                                    Lihat File
                                </a>
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">
                            Tidak ada surat ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $suratMasuk->appends(['q' => request('q'), 'per_page' => request('per_page')])->links() }}
    </div>
</div>

<script>
    document.querySelector('#sidebar-search')?.classList.add('bg-blue-100', 'text-blue-600', 'font-semibold');
</script>
@endsection
