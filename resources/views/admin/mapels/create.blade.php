@extends('admin.layouts.app')
@section('title','Tambah Mapel')
@section('content')
<h3>Tambah Mapel</h3>
<div class="card p-4">
  <form method="POST" action="{{ route('admin.mapels.store') }}">@csrf
    <div class="mb-3">
      <label class="form-label">Nama Mapel</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Kode (opsional)</label>
      <input type="text" name="code" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Guru (opsional)</label>
      <select name="teacher_id" class="form-control">
        <option value="">-- Pilih Guru --</option>
        @foreach($teachers as $t)
          <option value="{{ $t->id }}">{{ $t->name }}</option>
        @endforeach
      </select>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.mapels.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
