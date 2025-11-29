@extends('layouts.app')
@section('title','Realtime Absensi')
@section('content')
<h3>Daftar Absen Hari Ini</h3>
<table class="table" id="tbl">
  <thead><tr><th>NIS</th><th>Nama</th><th>Kelas</th><th>Waktu</th><th>Status</th></tr></thead>
  <tbody>
    @foreach($attendances as $a)
      <tr><td>{{ $a->student->nis }}</td><td>{{ $a->student->name }}</td><td>{{ $a->student->kelas->name ?? '-' }}</td><td>{{ $a->absent_at }}</td><td>{{ $a->status }}</td></tr>
    @endforeach
  </tbody>
</table>
@endsection

@push('scripts')<script>$(document).ready(()=>$('#tbl').DataTable());</script>@endpush
