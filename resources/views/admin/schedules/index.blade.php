@extends('admin.layouts.app')
@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Jadwal Pelajaran</h2>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">Tambah Jadwal</a>
    </div>

    <form class="mb-4" method="GET">
        <select name="kelas" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
            @endforeach
        </select>
        <select name="week_type" onchange="this.form.submit()">
            <option value="">Semua Minggu</option>
            <option value="1" {{ request('week_type') == '1' ? 'selected' : '' }}>Minggu 1 (Kejuruan)</option>
            <option value="2" {{ request('week_type') == '2' ? 'selected' : '' }}>Minggu 2 (Umum)</option>
        </select>
    </form>

    <table id="tbl3" class="table-auto w-full">
      <thead>
        <tr>
          <th>Kelas</th>
          <th>Hari</th>
          <th>Jam</th>
          <th>Mapel</th>
          <th>Guru</th>
          <th>Minggu</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($schedules as $s)
        <tr>
          <td>{{ $s->kelas->name }}</td>
          <td>{{ $s->day }}</td>
          <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
          <td>{{ $s->mapel?->name ?? $s->subject }}</td>
          <td>{{ $s->teacher?->name }}</td>
          <td>{{ $s->week_type }}</td>
          <td>
            <a href="{{ route('admin.schedules.edit', $s) }}">Edit</a>
            <form action="{{ route('admin.schedules.destroy', $s) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button>Hapus</button></form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4">{{ $schedules->links() }}</div>
</div>
@endsection
@push('scripts')<script>$(document).ready(()=>$('#tbl3').DataTable({"paging":false}));</script>@endpush
