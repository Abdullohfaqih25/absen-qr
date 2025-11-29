@extends('admin.layouts.app')
@section('title','Tambah Guru')
@section('content')
<h3>Tambah Guru Baru</h3>
<div class="card p-4">
  <form method="POST" action="{{ route('admin.teachers.store') }}">@csrf
    <div class="mb-3">
      <label class="form-label">Nama Guru</label>
      <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Password (opsional)</label>
      <input type="text" name="password" class="form-control" value="{{ old('password') }}" placeholder="Kosongkan untuk default 'password'">
    </div>
    <div class="mb-3">
      <label class="form-label">NIP</label>
      <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
