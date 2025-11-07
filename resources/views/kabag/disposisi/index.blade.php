@extends('layouts.kabag')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Daftar Disposisi Masuk</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">Nomor Surat</th>
                    <th class="px-4 py-2 border-b">Perihal</th>
                    <th class="px-4 py-2 border-b">Pengirim</th>
                    <th class="px-4 py-2 border-b">Instruksi</th>
                    <th class="px-4 py-2 border-b">Tanggal Disposisi</th>
                    <th class="px-4 py-2 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($disposisis as $i => $d)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b">{{ $i+1 }}</td>
                    <td class="px-4 py-2 border-b">{{ $d->surat->nomor_surat }}</td>
                    <td class="px-4 py-2 border-b">{{ $d->surat->perihal }}</td>
                    <td class="px-4 py-2 border-b">{{ $d->surat->pengirim }}</td>
                    <td class="px-4 py-2 border-b whitespace-pre-line">{{ Str::limit($d->instruksi, 120) }}</td>
                    <td class="px-4 py-2 border-b">{{ optional($d->tgl_disposisi)->format('d M Y H:i') ?? '-' }}</td>
                    <td class="px-4 py-2 border-b text-center">
                        <a href="{{ route('kabag.' . (Auth::user()->roles === 'kabag_keuangan' ? 'keuangan' : (Auth::user()->roles === 'kabag_persidangan' ? 'persidangan' : 'umum')) . '.disposisi.show', $d->id) }}"
                           class="text-blue-600 underline mr-2">Lihat</a>

                        <form action="{{ route('kabag.' . (Auth::user()->roles === 'kabag_keuangan' ? 'keuangan' : (Auth::user()->roles === 'kabag_persidangan' ? 'persidangan' : 'umum')) . '.disposisi.selesai', $d->id) }}"
                              method="POST" class="inline" onsubmit="return confirm('Tandai selesai dan arsipkan surat?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-green-700 underline">Selesai / Arsip</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">Belum ada disposisi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
