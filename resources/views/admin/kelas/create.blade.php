@extends('admin.layouts.app')
@section('title','Tambah Kelas')
@section('content')
<h3>Tambah Kelas Baru</h3>
<div class="card p-4">
  <form action="{{ route('admin.kelas.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Nama Kelas</label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Ruangan</label>
      <input type="text" name="room" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
