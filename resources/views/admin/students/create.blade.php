@extends('admin.layouts.app')
@section('title','Tambah Siswa')
@section('content')
<h3>Tambah Siswa Baru</h3>
<div class="card p-4">
<form method="POST" action="{{ route('admin.students.store') }}">@csrf
  <div class="mb-3">
    <label class="form-label">NIS</label>
    <input name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" required>
    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Siswa</label>
    <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Kelas</label>
    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
      <option value="">-- Pilih Kelas --</option>
      @foreach($kelas as $k)
        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
      @endforeach
    </select>
    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Batal</a>
</form>
</div>
@endsection
