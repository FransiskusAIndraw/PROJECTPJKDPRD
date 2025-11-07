@extends('layouts.tusekwan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-semibold mb-4">Disposisi Surat</h2>

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

        {{-- Link File Surat --}}
        <div class="border-2 border-grey-400 rounded-lg p-4 text-center text-sm">
            <span class="font-semibold">File Surat</span><br>
            <div class="text-middle mb-6">
                <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank"
                   class="text-purple-600 underline hover:text-purple-800">
                    Lihat File Surat
                </a>
            </div>
        </div>
    </div>

    

    {{-- Form Disposisi --}}
    <form action="{{ route('tusekwan.disposisi.store', $surat->id) }}" method="POST" class="grid grid-cols-3 gap-6">
        @csrf

        {{-- Kolom Disposisi --}}
        <div class="col-span-2">
            <label class="font-semibold">Disposisi</label>
            <textarea name="instruksi"
                      class="w-full border rounded-lg p-3 h-48 mt-2 focus:outline-purple-500"
                      placeholder="Isi Disposisi..." required></textarea>
        </div>

        {{-- Pilihan Penerima --}}
        <div class="col-span-1 flex flex-col gap-4">

            <div class="border rounded-lg p-3">
                <label class="font-semibold block mb-2">Pimpinan</label>
                <div class="space-y-2 text-sm">
                    @foreach($pimpinan as $p)
                        <label class="flex items-center gap-2">
                            <input type="radio" name="ke_user" value="{{ $p->id }}" required>
                            {{ $p->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit"
                class="w-full bg-indigo-700 hover:bg-indigo-800 text-white py-3 rounded-lg text-sm font-semibold transition">
                KIRIM
            </button>

        </div>
    </form>

</div>
@endsection
