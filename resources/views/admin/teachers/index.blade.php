@extends('admin.layouts.app')
@section('title','Data Guru')
@section('content')
<h3>Data Guru</h3>
<a href="{{ route('admin.teachers.create') }}" class="btn btn-primary mb-2">Tambah Guru</a>
<table class="table" id="tbl">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>NIP</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($teachers as $t)
    <tr>
      <td>{{ $t->name }}</td>
      <td>{{ $t->email ?? '-' }}</td>
      <td>{{ $t->nip ?? '-' }}</td>
      <td>
        <a href="{{ route('admin.teachers.edit',$t) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.teachers.destroy',$t) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin akan menghapus?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $teachers->links() }}
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tbl').DataTable({"paging":false}));</script>@endpush
