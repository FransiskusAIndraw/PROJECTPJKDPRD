@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📑 Daftar Disposisi</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('pimpinan.disposisi.create') }}" class="btn btn-primary">
            + Buat Disposisi Baru
        </a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>No Surat</th>
                <th>Perihal</th>
                <th>Diteruskan Kepada</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($disposisis as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->suratMasuk->no_surat ?? '-' }}</td>
                    <td>{{ $d->suratMasuk->perihal ?? '-' }}</td>
                    <td>{{ $d->diteruskanKepada->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $d->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($d->status) }}
                        </span>
                    </td>
                    <td>{{ $d->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('pimpinan.disposisi.show', $d->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        @if($d->status !== 'selesai')
                            <form action="{{ route('pimpinan.disposisi.updateStatus', $d->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Tandai Selesai</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada disposisi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
