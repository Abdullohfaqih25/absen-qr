@extends('admin.layouts.app')
@section('title','Tambah Jadwal')
@section('content')
<h3>Tambah Jadwal Baru</h3>
<div class="card p-4">
  <form method="POST" action="{{ route('admin.schedules.store') }}">@csrf
    <div class="mb-3">
      <label class="form-label">Kelas</label>
      <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelas as $k)
          <option value="{{ $k->id }}">{{ $k->name }}</option>
        @endforeach
      </select>
      @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Guru</label>
      <select name="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror" required>
        <option value="">-- Pilih Guru --</option>
        @foreach($teachers as $t)
          <option value="{{ $t->id }}">{{ $t->name }}</option>
        @endforeach
      </select>
      @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Mata Pelajaran</label>
      <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
      @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Hari</label>
        <select name="day" class="form-control @error('day') is-invalid @enderror" required>
          <option value="">-- Pilih Hari --</option>
          <option value="Monday">Senin</option>
          <option value="Tuesday">Selasa</option>
          <option value="Wednesday">Rabu</option>
          <option value="Thursday">Kamis</option>
          <option value="Friday">Jumat</option>
          <option value="Saturday">Sabtu</option>
        </select>
        @error('day')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-3 mb-3">
        <label class="form-label">Jam Mulai</label>
        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" required>
        @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-3 mb-3">
        <label class="form-label">Jam Selesai</label>
        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" required>
        @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
