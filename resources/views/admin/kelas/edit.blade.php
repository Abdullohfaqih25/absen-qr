@extends('admin.layouts.app')
@section('title','Edit Kelas')
@section('content')
<h3>Edit Kelas</h3>
<div class="card p-4">
  <form action="{{ route('admin.kelas.update',$kela) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Nama Kelas</label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $kela->name }}" required>
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Ruangan</label>
      <input type="text" name="room" class="form-control" value="{{ $kela->room }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
