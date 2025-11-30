@extends('admin.layouts.app')
@section('title',$dayTemplate->name)
@section('content')
<h3>{{ $dayTemplate->name }}</h3>
<p class="text-muted">{{ $dayTemplate->description ?? 'No description' }}</p>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Jam Mulai</th>
      <th>Jam Selesai</th>
      <th>Mapel</th>
      <th>Guru</th>
      <th>Topic</th>
    </tr>
  </thead>
  <tbody>
    @foreach($dayTemplate->slots as $slot)
    <tr>
      <td>{{ $slot->start_time }}</td>
      <td>{{ $slot->end_time }}</td>
      <td>{{ $slot->mapel?->name ?? '-' }}</td>
      <td>{{ $slot->teacher?->name ?? '-' }}</td>
      <td>{{ $slot->topic ?? '-' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<a href="{{ route('admin.day-templates.edit', $dayTemplate) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('admin.day-templates.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
