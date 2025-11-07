@extends('layouts.pimpinan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-semibold mb-4">Disposisi Surat (Instruksi Pimpinan)</h2>

    {{-- Informasi Surat --}}
    <div class="grid grid-cols-5 gap-4 mb-6">
        <div class="border-2 border-grey-400 rounded-lg p-4 text-center text-sm">
            <span class="font-semibold">Nomor Surat</span><br>
            {{ $surat->nomor_surat }}
        </div>

        <div class="border-2 border-grey-400 rounded-lg p-4 text-center text-sm">
            <span class="font-semibold">Perihal</span><br>
            {{ $surat->perihal }}
        </div>

        <div class="border-2 border-grey-400 rounded-lg p-4 text-center text-sm">
            <span class="font-semibold">Tanggal Surat</span><br>
            {{ $surat->tanggal_surat->format('d M Y') }}
        </div>

        <div class="border-2 border-grey-400 rounded-lg p-4 text-center text-sm">
            <span class="font-semibold">Asal Surat</span><br>
            {{ $surat->pengirim }}
        </div>

        <div class="border-2 border-grey-400 rounded-lg p-4 text-center text-sm">
            <span class="font-semibold">File Surat</span><br>
            <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank"
               class="text-purple-600 underline hover:text-purple-800">
                Lihat File Surat
            </a>
        </div>
    </div>

    {{-- RIWAYAT DISPOSISI --}}
    <h3 class="font-semibold mb-2">Riwayat Disposisi</h3>
    <div class="border rounded-lg p-4 mb-6 bg-gray-50">
        <pre class="whitespace-pre-wrap text-sm text-gray-700">{{ $disposisi->instruksi }}</pre>
    </div>

    {{-- FORM TAMBAH INSTRUKSI PIMPINAN --}}
    <form action="{{ route('pimpinan.disposisi.update', $surat->id) }}" method="POST" class="grid grid-cols-3 gap-6">
        @csrf
        @method('PUT')

        <div class="col-span-2">
            <label class="font-semibold">Instruksi Pimpinan</label>
            <textarea name="instruksi_tambahan"
                      class="w-full border rounded-lg p-3 h-48 mt-2 focus:outline-purple-500"
                      placeholder="Tambahkan instruksi pimpinan disini..." required></textarea>
        </div>

        <div class="col-span-1 flex flex-col gap-4">
            <button type="submit"
                class="w-full bg-indigo-700 hover:bg-indigo-800 text-white py-3 rounded-lg text-sm font-semibold transition">
                KIRIM KEMBALI KE TU SEKWAN
            </button>
        </div>
    </form>

</div>
@endsection
