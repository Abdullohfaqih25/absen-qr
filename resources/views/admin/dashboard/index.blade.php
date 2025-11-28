@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
<h3>Dashboard Admin</h3>
<div class="row">
  <div class="col-md-4"><div class="card card-ghost p-3"><h5>Hadir Hari Ini</h5><h2>{{ $totalHadir }}</h2></div></div>
  <div class="col-md-4"><div class="card card-ghost p-3"><h5>Terlambat</h5><h2>{{ $terlambat }} ({{ $persenTerlambat }}%)</h2></div></div>
  <div class="col-md-4"><div class="card card-ghost p-3"><h5>Minggu Ini</h5><canvas id="chartWeek"></canvas></div></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = {!! json_encode(array_column($week,'date')) !!};
  const data = {!! json_encode(array_column($week,'count')) !!};
  const ctx = document.getElementById('chartWeek').getContext('2d');
  new Chart(ctx, { type:'line', data:{ labels:labels, datasets:[{ label:'Absensi', data:data, fill:false }] }, options:{} });
</script>
@endpush
