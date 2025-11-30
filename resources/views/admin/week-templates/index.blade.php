@extends('admin.layouts.app')
@section('title','Week Templates')
@section('content')
<h3>Week Templates</h3>
<a href="{{ route('admin.week-templates.create') }}" class="btn btn-primary mb-2">Tambah Week Template</a>
<table class="table" id="tblWeekTemplates">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Kelas</th>
      <th>Week Type</th>
      <th>Days</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($weekTemplates as $wt)
    <tr>
      <td>{{ $wt->name }}</td>
      <td>{{ $wt->kelas?->name ?? '-' }}</td>
      <td><span class="badge bg-info">Minggu {{ $wt->week_type }}</span></td>
      <td>{{ $wt->days->count() }} hari</td>
      <td>
        <a href="{{ route('admin.week-templates.show', $wt) }}" class="btn btn-sm btn-info">Lihat</a>
        <a href="{{ route('admin.week-templates.edit', $wt) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.week-templates.destroy', $wt) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin akan menghapus?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="5" class="text-center text-muted">Belum ada week templates</td></tr>
    @endforelse
  </tbody>
</table>
{{ $weekTemplates->links() }}
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tblWeekTemplates').DataTable({"paging":false}));</script>@endpush
