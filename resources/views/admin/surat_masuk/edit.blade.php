@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Surat Masuk</h1>
    <form action="{{ route('surat-masuk.update', $surat) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-4">
            <label for="no_surat" class="block">No Surat</label>
            <input type="text" name="no_surat" id="no_surat"
                   class="w-full border rounded px-2 py-1"
                   value="{{ old('no_surat', $surat->no_surat) }}">
            @error('no_surat') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label for="pengirim" class="block">Pengirim</label>
            <input type="text" name="pengirim" id="pengirim"
                   class="w-full border rounded px-2 py-1"
                   value="{{ old('pengirim', $surat->pengirim) }}">
            @error('pengirim') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label for="tgl_surat" class="block">Tanggal Surat</label>
            <input type="date" name="tgl_surat" id="tgl_surat"
                   class="w-full border rounded px-2 py-1"
                   value="{{ old('tgl_surat', $surat->tgl_surat->format('Y-m-d')) }}">
            @error('tgl_surat') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label for="file_surat" class="block">File Surat (PDF)</label>
            <input type="file" name="file_surat" id="file_surat"
                   class="w-full border rounded px-2 py-1">
            @error('file_surat') <div class="text-red-600">{{ $message }}</div> @enderror
            @if($surat->file_surat)
            <p class="mt-2">File sekarang: <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank">{{ $surat->file_surat }}</a></p>
            @endif
        </div>

        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Update
        </button>
    </form>
</div>
@endsection
