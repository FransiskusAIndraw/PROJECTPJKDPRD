@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Surat Masuk</h1>
    <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary mb-4">Tambah Surat Masuk</a>
    <table class="table-auto w-full border">
        <thead>
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">No Surat</th>
                <th class="px-4 py-2">Pengirim</th>
                <th class="px-4 py-2">Tanggal Surat</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($surat as $item)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2">{{ $item->no_surat }}</td>
                <td class="border px-4 py-2">{{ $item->pengirim }}</td>
                <td class="border px-4 py-2">{{ $item->tgl_surat->format('d-m-Y') }}</td>
                <td class="border px-4 py-2">{{ $item->status_surat }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('surat-masuk.show', $item) }}" class="text-blue-600">Lihat</a> |
                    <a href="{{ route('surat-masuk.edit', $item) }}" class="text-yellow-600">Edit</a> |
                    <form action="{{ route('surat-masuk.destroy', $item) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600"
                                onclick="return confirm('Yakin ingin dihapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
