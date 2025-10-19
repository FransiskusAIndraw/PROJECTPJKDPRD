@extends('layouts.tusekwan')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Surat Masuk (Screening & Arsip)</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border">No. Surat</th>
                <th class="px-4 py-2 border">Perihal</th>
                <th class="px-4 py-2 border">Asal Surat</th>
                <th class="px-4 py-2 border">Tanggal Masuk</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suratMasuk as $surat)
                <tr>
                    <td class="border px-4 py-2">{{ $surat->nomor_surat }}</td>
                    <td class="border px-4 py-2">{{ $surat->perihal }}</td>
                    <td class="border px-4 py-2">{{ $surat->asal_surat }}</td>
                    <td class="border px-4 py-2">{{ $surat->tanggal_masuk }}</td>
                    <td class="border px-4 py-2">
                        <span class="@if($surat->status == 'arsip') bg-green-100 text-green-700 
                                     @elseif($surat->status == 'selesai') bg-blue-100 text-blue-700 
                                     @else bg-gray-100 text-gray-700 @endif 
                                     px-2 py-1 rounded text-sm">
                            {{ ucfirst($surat->status) }}
                        </span>
                    </td>
                    <td class="border px-4 py-2 text-center space-x-2">
                        <a href="{{ route('tusekwan.surat_masuk.show', $surat->id) }}" 
                           class="text-blue-600 hover:underline">Lihat</a>

                        @if ($surat->status === 'selesai')
                            <form action="{{ route('arsip.store') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="surat_masuk_id" value="{{ $surat->id }}">
                                <button type="submit" 
                                        class="text-green-600 hover:underline"
                                        onclick="return confirm('Arsipkan surat ini?')">
                                    Arsipkan
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                        Tidak ada surat masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
