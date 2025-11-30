@extends('admin.layouts.app')
@section('title',$weekTemplate->name)
@section('content')
<h3>{{ $weekTemplate->name }}</h3>
<p class="text-muted">Kelas: {{ $weekTemplate->kelas?->name ?? '-' }} | Week Type: Minggu {{ $weekTemplate->week_type }}</p>

<div class="row">
@foreach($weekTemplate->days as $day)
<div class="col-md-6 mb-3">
  <div class="card">
    <div class="card-header fw-bold">{{ $day->day_name }}</div>
    <div class="card-body">
      @if($day->template)
        <h6>{{ $day->template->name }}</h6>
        <table class="table table-sm">
          <thead>
            <tr>
              <th>Waktu</th>
              <th>Mapel</th>
              <th>Guru</th>
            </tr>
          </thead>
          <tbody>
            @foreach($day->template->slots as $slot)
            <tr>
              <td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
              <td>{{ $slot->mapel?->name ?? '-' }}</td>
              <td>{{ $slot->teacher?->name ?? '-' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p class="text-muted">-</p>
      @endif
    </div>
  </div>
</div>
@endforeach
</div>

<a href="{{ route('admin.week-templates.edit', $weekTemplate) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('admin.week-templates.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
