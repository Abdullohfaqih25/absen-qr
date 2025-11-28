@extends('admin.layouts.app')
@section('title','Kelas')
@section('content')
<h3>Daftar Kelas</h3>
<a href="{{ route('admin.kelas.create') }}" class="btn btn-primary mb-2">Tambah</a>
<table class="table" id="tbl2">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Ruang</th>
      <th>Jumlah Siswa</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($kelas as $k)
    <tr>
      <td>{{ $k->name }}</td>
      <td>{{ $k->room ?? '-' }}</td>
      <td>{{ $k->students()->count() }}</td>
      <td>
        <a href="{{ route('admin.kelas.edit',$k) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.kelas.destroy',$k) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin akan menghapus?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $kelas->links() }}
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tbl2').DataTable({"paging":false}));</script>@endpush
