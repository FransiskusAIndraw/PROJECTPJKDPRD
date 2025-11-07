@extends('layouts.tusekre')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Surat Perlu Direvisi</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-md">
            <thead class="bg-blue-700 text-white">
                <tr class="text-left">
                    <th class="px-4 py-2 border-b">Nomor Surat</th>
                    <th class="px-4 py-2 border-b">Perihal</th>
                    <th class="px-4 py-2 border-b">Tanggal Surat</th>
                    <th class="px-4 py-2 border-b">Catatan Revisi</th>
                    <th class="px-4 py-2 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratPerluRevisi as $surat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $surat->nomor_surat }}</td>
                        <td class="px-4 py-2 border-b">{{ $surat->perihal }}</td>
                        <td class="px-4 py-2 border-b">{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border-b text-gray-600">
                            {{ $surat->catatan_tusekwan ?? 'Tidak ada catatan.' }}
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('tusekre.surat_masuk.edit_revisi', $surat->id) }}" 
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                Revisi
                                </a>
                                <form action="{{ route('tusekre.surat_masuk.update_revisi', $surat->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">
                            Tidak ada surat yang perlu direvisi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $suratPerluRevisi->links() }}
    </div>
</div>
@endsection
