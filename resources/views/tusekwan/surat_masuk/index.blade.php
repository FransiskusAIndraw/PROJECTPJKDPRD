@extends('layouts.tusekwan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Daftar Surat Masuk Menunggu Verifikasi</h2>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($suratMasuk->isEmpty())
        <p class="text-gray-600">Tidak ada surat yang menunggu verifikasi.</p>
    @else
        <table class="w-full border border-gray-300 rounded-lg text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left border-b">No</th>
                    <th class="p-2 text-left border-b">Nomor Surat</th>
                    <th class="p-2 text-left border-b">Perihal</th>
                    <th class="p-2 text-left border-b">Tanggal Surat</th>
                    <th class="p-2 text-left border-b">Asal Surat</th>
                    <th class="p-2 text-left border-b">Status</th>
                    <th class="p-2 text-left border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratMasuk as $index => $surat)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border-b">{{ $index + 1 }}</td>
                        <td class="p-2 border-b">{{ $surat->nomor_surat }}</td>
                        <td class="p-2 border-b">{{ Str::limit($surat->perihal, 60) }}</td>
                        <td class="p-2 border-b">{{ $surat->tanggal_surat->format('d M Y') }}</td>
                        <td class="p-2 border-b">{{ $surat->pengirim }}</td>
                        <td class="p-2 border-b">
                            <span class="px-2 py-1 text-xs rounded 
                                @if($surat->status === 'terkirim_ke_tusekwan') bg-yellow-100 text-yellow-800
                                @elseif($surat->status === 'menunggu_verifikasi') bg-blue-100 text-blue-800
                                @elseif($surat->status === 'perlu_revisi') bg-red-100 text-red-800
                                @elseif($surat->status === 'terverifikasi') bg-green-100 text-green-800
                                @endif">
                                {{ \App\Models\SuratMasuk::statusLabel($surat->status) }}
                            </span>
                        </td>
                        <td class="p-2 border-b">
                            <a href="{{ route('tusekwan.surat_masuk.edit', $surat->id) }}" 
                               class="text-blue-600 hover:underline">Verifikasi</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
