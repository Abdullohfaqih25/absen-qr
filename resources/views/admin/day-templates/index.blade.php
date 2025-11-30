@extends('admin.layouts.app')
@section('title','Day Templates')
@section('content')
<h3>Day </h3>
<a href="{{ route('admin.day-templates.create') }}" class="btn btn-primary mb-2">Tambah Day </a>
<table class="table" id="tblDayTemplates">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Slot Count</th>
      <th>Deskripsi</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($dayTemplates as $dt)
    <tr>
      <td>{{ $dt->name }}</td>
      <td><span class="badge bg-info">{{ $dt->slots->count() }}</span></td>
      <td>{{ $dt->description ?? '-' }}</td>
      <td>
        <a href="{{ route('admin.day-templates.show', $dt) }}" class="btn btn-sm btn-info">Lihat</a>
        <a href="{{ route('admin.day-templates.edit', $dt) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.day-templates.destroy', $dt) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin akan menghapus?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="4" class="text-center text-muted">Belum ada day </td></tr>
    @endforelse
  </tbody>
</table>
{{ $dayTemplates->links() }}
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tblDayTemplates').DataTable({"paging":false}));</script>@endpush
