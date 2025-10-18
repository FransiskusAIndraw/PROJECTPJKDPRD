@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📝 Buat Disposisi Baru</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pimpinan.disposisi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="surat_masuk_id" class="form-label">Pilih Surat Masuk</label>
            <select name="surat_masuk_id" id="surat_masuk_id" class="form-select" required>
                <option value="">-- Pilih Surat --</option>
                @foreach ($suratMasuks as $s)
                    <option value="{{ $s->id }}">{{ $s->no_surat }} - {{ $s->perihal }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="diteruskan_kepada" class="form-label">Diteruskan Kepada</label>
            <select name="diteruskan_kepada" id="diteruskan_kepada" class="form-select" required>
                <option value="">-- Pilih Tujuan --</option>
                @foreach ($staffs as $st)
                    <option value="{{ $st->id }}">{{ $st->name }} ({{ $st->roles }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan / Instruksi</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Tambahkan catatan atau instruksi khusus..." required></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('pimpinan.disposisi.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-success">Kirim Disposisi</button>
        </div>
    </form>
</div>
@endsection
