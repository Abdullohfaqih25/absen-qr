@extends('admin.layouts.app')
@section('title','Data Siswa')
@section('content')
<h3>Data Siswa</h3>

<div class="card p-3 mb-3">
  <form method="GET" class="row g-2">
    <div class="col-md-6">
      <input type="text" name="q" class="form-control" placeholder="Cari berdasarkan NIS atau Nama" value="{{ request('q') }}">
    </div>
    <div class="col-md-6">
      <button type="submit" class="btn btn-primary">Cari</button>
      <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Reset</a>
      <a href="{{ route('admin.students.create') }}" class="btn btn-success">+ Tambah Siswa</a>
    </div>
  </form>
</div>

<table class="table table-hover" id="studentsTbl">
  <thead>
    <tr>
      <th>NIS</th>
      <th>Nama</th>
      <th>Kelas</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($students as $s)
    <tr>
      <td>{{ $s->nis }}</td>
      <td>{{ $s->name }}</td>
      <td>{{ $s->kelas->name ?? '-' }}</td>
      <td>
        <a href="{{ route('admin.students.edit',$s) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.students.destroy',$s) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin akan menghapus?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="4" class="text-center py-4">Tidak ada data siswa</td>
    </tr>
    @endforelse
  </tbody>
</table>
{{ $students->links() }}
@endsection

@push('scripts')
<script>$(document).ready(()=>$('#studentsTbl').DataTable({"paging":false}));</script>
@endpush
