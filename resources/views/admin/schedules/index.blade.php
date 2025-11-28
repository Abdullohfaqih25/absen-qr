@extends('admin.layouts.app')
@section('title','Jadwal')
@section('content')
<h3>Daftar Jadwal</h3>
<a href="{{ route('admin.schedules.create') }}" class="btn btn-primary mb-2">Tambah Jadwal</a>
<table class="table" id="tbl3">
  <thead>
    <tr>
      <th>Kelas</th>
      <th>Guru</th>
      <th>Mata Pelajaran</th>
      <th>Hari</th>
      <th>Waktu</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($schedules as $s)
    <tr>
      <td>{{ $s->kelas->name ?? '-' }}</td>
      <td>{{ $s->teacher->name ?? '-' }}</td>
      <td>{{ $s->subject }}</td>
      <td>{{ $s->day }}</td>
      <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
      <td>
        <a href="{{ route('admin.schedules.edit',$s) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.schedules.destroy',$s) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin akan menghapus?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $schedules->links() }}
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tbl3').DataTable({"paging":false}));</script>@endpush
