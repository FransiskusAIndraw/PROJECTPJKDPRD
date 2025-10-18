@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📄 Detail Disposisi</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $disposisi->suratMasuk->perihal ?? 'Tidak ada perihal' }}</h5>
            <p class="text-muted mb-2">
                <strong>No. Surat:</strong> {{ $disposisi->suratMasuk->no_surat ?? '-' }} <br>
                <strong>Tanggal:</strong> {{ $disposisi->suratMasuk->tanggal ?? '-' }}
            </p>

            <hr>

            <p><strong>Diteruskan Kepada:</strong> {{ $disposisi->diteruskanKepada->name ?? '-' }}</p>
            <p><strong>Catatan / Instruksi:</strong></p>
            <div class="border rounded p-3 bg-light mb-3">
                {{ $disposisi->catatan }}
            </div>

            <p>
                <strong>Status:</strong>
                <span class="badge {{ $disposisi->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($disposisi->status) }}
                </span>
            </p>

            @if($disposisi->status !== 'selesai')
                <form action="{{ route('pimpinan.disposisi.updateStatus', $disposisi->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success mt-2">Tandai Selesai</button>
                </form>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('pimpinan.disposisi.index') }}" class="btn btn-secondary">⬅ Kembali</a>
    </div>
</div>
@endsection
