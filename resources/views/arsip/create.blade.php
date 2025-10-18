@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Arsipkan Surat</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($eligible->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded-lg">
            Tidak ada surat yang siap diarsipkan.
        </div>
    @else
        <form action="{{ route('arsip.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf
            <div class="mb-4">
                <label for="surat_masuk_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Surat</label>
                <select name="surat_masuk_id" id="surat_masuk_id" class="border rounded-lg p-2 w-full">
                    <option value="">-- Pilih Surat --</option>
                    @foreach ($eligible as $surat)
                        <option value="{{ $surat->id }}">
                            {{ $surat->nomor_surat }} — {{ $surat->perihal }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Arsipkan Surat
            </button>
        </form>
    @endif
</div>
@endsection
