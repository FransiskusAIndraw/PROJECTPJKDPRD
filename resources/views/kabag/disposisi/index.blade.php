@foreach($disposisis as $d)
<tr>
  <td>{{ $d->surat->nomor_surat }}</td>
  <td>{{ $d->surat->perihal }}</td>
  <td>{{ $d->instruksi }}</td>
  <td>
    <form action="{{ route('kabag.keuangan.disposisi.selesai', $d->id) }}" method="POST" onsubmit="return confirm('Tandai selesai dan arsipkan surat?')">
        @csrf
        @method('PATCH')
        <button class="px-3 py-1 bg-green-600 text-white rounded">Tandai Selesai & Arsipkan</button>
    </form>
  </td>
</tr>
@endforeach
