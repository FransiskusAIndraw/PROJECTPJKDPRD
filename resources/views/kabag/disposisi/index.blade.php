@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Disposisi Masuk untuk Kabag</h3>

    @if($suratUntukKabag->isEmpty())
        <p>Tidak ada surat yang menunggu diproses.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nomor Surat</th>
                    <th>Pengirim</th>
                    <th>Perihal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratUntukKabag as $surat)
                <tr>
                    <td>{{ $surat->nomor_surat }}</td>
                    <td>{{ $surat->pengirim }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td>
                        <form action="{{ route(str_replace('dashboard', '', request()->route()->getName()) . 'disposisi.selesai', $surat->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm" onclick="return confirm('Tandai selesai & arsipkan?')">
                                Selesai & Arsipkan
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
