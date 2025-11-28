@extends('admin.layouts.app')
@section('title','Edit Guru')
@section('content')
<h3>Edit Guru</h3>
<div class="card p-4">
  <form method="POST" action="{{ route('admin.teachers.update',$teacher) }}">@csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Nama Guru</label>
      <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$teacher->name) }}" required>
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email',$teacher->email) }}">
    </div>
    <div class="mb-3">
      <label class="form-label">NIP</label>
      <input type="text" name="nip" class="form-control" value="{{ old('nip',$teacher->nip) }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
