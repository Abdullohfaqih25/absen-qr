@extends('admin.layouts.app')
@section('title','Absensi')
@section('content')
<h3>Data Absensi</h3>
<div class="card p-3 mb-3">
  <form method="GET" class="row g-2">
    <div class="col-md-3">
      <label class="form-label">Tanggal</label>
      <input type="date" name="date" class="form-control" value="{{ request('date') }}">
    </div>
    <div class="col-md-3">
      <label class="form-label">Kelas</label>
      <select name="kelas" class="form-select">
        <option value="">-- Semua Kelas --</option>
        @foreach($kelas as $k)
          <option value="{{ $k->id }}" {{ request('kelas')==$k->id? 'selected':'' }}>{{ $k->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">NIS/Nama</label>
      <input name="nis" class="form-control" placeholder="Cari NIS atau Nama" value="{{ request('nis') }}">
    </div>
    <div class="col-md-3 d-flex align-items-end gap-2">
      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('admin.attendances.export', request()->all()) }}" class="btn btn-success">Export Excel</a>
    </div>
  </form>
</div>

<table class="table table-hover" id="tblA">
  <thead>
    <tr>
      <th>NIS</th>
      <th>Nama Siswa</th>
      <th>Kelas</th>
      <th>Tanggal & Waktu</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @forelse($attendances as $a)
    <tr>
      <td>{{ $a->student->nis }}</td>
      <td>{{ $a->student->name }}</td>
      <td>{{ $a->student->kelas->name ?? '-' }}</td>
      <td>{{ $a->absent_at ? \Carbon\Carbon::parse($a->absent_at)->format('d-m-Y H:i') : '-' }}</td>
      <td>
        @if($a->status == 'Hadir')
          <span class="badge bg-success">Hadir</span>
        @elseif($a->status == 'Terlambat')
          <span class="badge bg-warning">Terlambat</span>
        @else
          <span class="badge bg-danger">{{ $a->status }}</span>
        @endif
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="5" class="text-center py-4">Tidak ada data absensi</td>
    </tr>
    @endforelse
  </tbody>
</table>
{{ $attendances->links() }}
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tblA').DataTable({"paging":false}));</script>@endpush
