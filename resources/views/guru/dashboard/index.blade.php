@extends('layouts.app')
@section('title','Dashboard Guru')
@section('content')
<h3>Dashboard Guru</h3>
<div class="row">
  <div class="col-md-6"><div class="card p-3"><h5>QR Hari Ini</h5>
    @if($token)
      <p><strong>Token:</strong> {{ $token->token }}</p>
      <p><strong>Absensi via token ini:</strong> {{ $attCount }}</p>
      <a class="btn btn-sm btn-primary" href="{{ route('guru.qr.show') }}">Lihat QR</a>
    @else
      <p>Tidak ada QR untuk hari ini.</p>
      <a class="btn btn-sm btn-primary" href="{{ route('guru.qr.show') }}">Buat QR</a>
    @endif
      <hr>
      @php
        $today = \Carbon\Carbon::today()->toDateString();
        $avail = null;
        if(auth()->check()){
            $teacherId = auth()->user()->related_id;
            $avail = App\Models\TeacherAvailability::where('teacher_id',$teacherId)->where('date',$today)->first();
        }
      @endphp
      <form method="POST" action="{{ route('guru.availability.toggle') }}">
        @csrf
        @if($avail && $avail->is_absent)
          <button type="submit" name="action" value="present" class="btn btn-sm btn-success">Batalkan Ketidakhadiran</button>
        @else
          <button type="submit" name="action" value="absent" class="btn btn-sm btn-danger">Konfirmasi Tidak Masuk</button>
        @endif
      </form>
  </div></div>
  <div class="col-md-6"><div class="card p-3"><h5>Aksi Cepat</h5>
    <div class="d-grid gap-2">
      <a href="{{ route('guru.qr.show') }}" class="btn btn-primary">
        <i class="fas fa-qrcode me-2"></i>Lihat QR
      </a>
      <a href="{{ route('guru.qr.realtime') }}" class="btn btn-info">
        <i class="fas fa-eye me-2"></i>Realtime Absensi
      </a>
    </div>
  </div></div>
</div>
<!-- Teacher Today's Schedule -->
@if(isset($todaySchedulesTeacher) && $todaySchedulesTeacher->count())
  <div class="row mt-4">
    <div class="col-12">
      <div class="card p-3">
        <h5>Jadwal Hari Ini</h5>
        <div class="list-group list-group-flush mt-3">
          @foreach($todaySchedulesTeacher as $sch)
            <div class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">{{ $sch->mapel ?? $sch->subject ?? '-' }}</div>
                <div class="small text-muted">Kelas: {{ $sch->kelas ?? '-' }}</div>
              </div>
              <div class="text-end">
                <div class="fw-semibold">{{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}</div>
                <div class="small text-muted">Sesi</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@else
  <div class="row mt-4">
    <div class="col-12">
      <div class="card p-3 text-center text-muted">
        <div>Tidak ada jadwal untuk hari ini.</div>
      </div>
    </div>
  </div>
@endif
@endsection
