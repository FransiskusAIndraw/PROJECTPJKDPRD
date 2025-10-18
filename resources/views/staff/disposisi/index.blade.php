    @extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Daftar Disposisi Saya</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($disposisis->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded-lg">
            Tidak ada disposisi yang diteruskan kepada Anda.
        </div>
    @else
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Nomor Surat</th>
                        <th class="px-4 py-2 text-left">Perihal</th>
                        <th class="px-4 py-2 text-left">Dari</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($disposisis as $disposisi)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $disposisi->suratMasuk->nomor_surat }}</td>
                            <td class="px-4 py-2">{{ $disposisi->suratMasuk->perihal }}</td>
                            <td class="px-4 py-2">{{ $disposisi->user->name }}</td>
                            <td class="px-4 py-2">
                                @if($disposisi->status === 'selesai')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-sm">Selesai</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-sm">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('staff.disposisi.show', $disposisi->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
