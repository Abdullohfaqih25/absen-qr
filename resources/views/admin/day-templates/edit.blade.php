@extends('admin.layouts.app')
@section('title','Edit Day ')
@section('content')
<h3>Edit Day </h3>
<div class="card p-4">
  <form method="POST" action="{{ route('admin.day-templates.update', $dayTemplate) }}">@csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Nama Template</label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $dayTemplate->name) }}">
      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="description" class="form-control" rows="2">{{ old('description', $dayTemplate->description) }}</textarea>
    </div>

    <div class="mb-3">
      <h5>Time Slots</h5>
      <button type="button" class="btn btn-sm btn-secondary mb-2" onclick="addSlot()">+ Tambah Slot</button>
      <div id="slotsContainer">
        @foreach($dayTemplate->slots as $idx => $slot)
        <div class="slot-row p-3 border rounded mb-2" data-slot="{{ $idx }}">
          <div class="row">
            <div class="col-md-2">
              <label class="form-label">Jam Mulai</label>
              <input type="time" name="slots[{{ $idx }}][start_time]" class="form-control" required value="{{ old('slots.'.$idx.'.start_time', $slot->start_time) }}">
            </div>
            <div class="col-md-2">
              <label class="form-label">Jam Selesai</label>
              <input type="time" name="slots[{{ $idx }}][end_time]" class="form-control" required value="{{ old('slots.'.$idx.'.end_time', $slot->end_time) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">Mapel</label>
              <select name="slots[{{ $idx }}][mapel_id]" class="form-control" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach($mapels as $m)
                  <option value="{{ $m->id }}" {{ $slot->mapel_id == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Guru</label>
              <select name="slots[{{ $idx }}][teacher_id]" class="form-control">
                <option value="">-- Pilih Guru --</option>
                @foreach($teachers as $t)
                  <option value="{{ $t->id }}" {{ $slot->teacher_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
              <button type="button" class="btn btn-sm btn-danger" onclick="removeSlot({{ $idx }})">Hapus</button>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.day-templates.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>

<script>
let slotCount = {{ $dayTemplate->slots->count() }};
function addSlot() {
  const container = document.getElementById('slotsContainer');
  const slotHtml = `
    <div class="slot-row p-3 border rounded mb-2" data-slot="${slotCount}">
      <div class="row">
        <div class="col-md-2">
          <label class="form-label">Jam Mulai</label>
          <input type="time" name="slots[${slotCount}][start_time]" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Jam Selesai</label>
          <input type="time" name="slots[${slotCount}][end_time]" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Mapel</label>
          <select name="slots[${slotCount}][mapel_id]" class="form-control" required>
            <option value="">-- Pilih Mapel --</option>
            @foreach($mapels as $m)
              <option value="{{ $m->id }}">{{ $m->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Guru</label>
          <select name="slots[${slotCount}][teacher_id]" class="form-control">
            <option value="">-- Pilih Guru --</option>
            @foreach($teachers as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
          <button type="button" class="btn btn-sm btn-danger" onclick="removeSlot(${slotCount})">Hapus</button>
        </div>
      </div>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', slotHtml);
  slotCount++;
}

function removeSlot(index) {
  const slot = document.querySelector(`[data-slot="${index}"]`);
  if (slot) slot.remove();
}
</script>
@endsection
