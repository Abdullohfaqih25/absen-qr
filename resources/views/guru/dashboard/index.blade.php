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
  </div></div>
  <div class="col-md-6"><div class="card p-3"><h5>Quick Links</h5>
    <ul>
      <li><a href="{{ route('guru.qr.realtime') }}">Realtime Absensi</a></li>
    </ul>
  </div></div>
</div>
@endsection
