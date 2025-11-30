@extends('admin.layouts.app')
@section('title','Edit Week Template')
@section('content')
<h3>Edit Week </h3>
<div class="card p-4">
  <form method="POST" action="{{ route('admin.week-templates.update', $weekTemplate) }}">@csrf @method('PUT')
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Kelas</label>
          <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
              <option value="{{ $k->id }}" {{ $weekTemplate->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
            @endforeach
          </select>
          @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Week Type</label>
          <select name="week_type" class="form-control @error('week_type') is-invalid @enderror" required>
            <option value="">-- Pilih Week --</option>
            <option value="1" {{ $weekTemplate->week_type == 1 ? 'selected' : '' }}>Minggu 1 (Kejuruan)</option>
            <option value="2" {{ $weekTemplate->week_type == 2 ? 'selected' : '' }}>Minggu 2 (Umum)</option>
          </select>
          @error('week_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nama </label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $weekTemplate->name) }}">
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <h5>Pilih Day  untuk Setiap Hari</h5>
      @foreach($days as $idx => $day)
        @php
          $currentDay = $weekTemplate->days->where('day_name', $day)->first();
        @endphp
      <div class="mb-2 p-3 border rounded">
        <label class="form-label fw-bold">{{ $day }}</label>
        <select name="days[{{ $idx }}][day_template_id]" class="form-control">
          <option value="">-- Tidak Ada (Hari Libur) --</option>
          @foreach($dayTemplates as $dt)
            <option value="{{ $dt->id }}" {{ $currentDay && $currentDay->day_template_id == $dt->id ? 'selected' : '' }}>{{ $dt->name }} ({{ $dt->slots->count() }} slots)</option>
          @endforeach
        </select>
        <input type="hidden" name="days[{{ $idx }}][day_name]" value="{{ $day }}">
      </div>
      @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.week-templates.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
