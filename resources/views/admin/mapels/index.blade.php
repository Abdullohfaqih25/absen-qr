@extends('admin.layouts.app')
@section('title','Mapel')
@section('content')
<h3>Daftar Mata Pelajaran</h3>
<a href="{{ route('admin.mapels.create') }}" class="btn btn-primary mb-2">Tambah Mapel</a>
<table class="table" id="tblMapel">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Kode</th>
      <th>Guru</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($mapels as $m)
    <tr>
      <td>{{ $m->name }}</td>
      <td>{{ $m->code ?? '-' }}</td>
      <td>{{ $m->teacher?->name ?? '-' }}</td>
      <td>
        <a href="{{ route('admin.mapels.edit',$m) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.mapels.destroy',$m) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin akan menghapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $mapels->links() }}
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tblMapel').DataTable({"paging":false}));</script>@endpush
