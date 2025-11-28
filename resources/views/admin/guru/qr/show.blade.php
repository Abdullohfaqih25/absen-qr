@extends('layouts.app')
@section('title','QR Hari Ini')
@section('content')
<h3>QR Hari Ini</h3>
<div class="row">
  <div class="col-md-6">
    <div id="qrcode"></div>
    <div class="mt-3">
      <form method="POST" action="{{ route('guru.qr.regenerate') }}">@csrf<button class="btn btn-warning">Regenerate</button></form>
    </div>
  </div>
  <div class="col-md-6">
    <h5>Contoh Isi QR (JSON)</h5>
    <pre id="qrjson"></pre>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  const token = '{{ $token->token }}';
  const payload = JSON.stringify({ token: token, nis: 'SISWA_NIS_DIPILIH' });
  new QRCode(document.getElementById('qrcode'), { text: payload, width:200, height:200 });
  document.getElementById('qrjson').innerText = payload;
</script>
@endpush
