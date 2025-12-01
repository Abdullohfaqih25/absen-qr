@extends('layouts.app')
@section('title','Scan QR')
@section('content')
<h3>Scan QR</h3>
<div class="row">
  <div class="col-md-8">
    <div id="reader" style="width:100%;"></div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5>Manual</h5>
        <form id="manualForm">
          <div class="mb-2"><label>NIS</label><input id="nisInput" class="form-control"></div>
          <div class="mb-2"><label>Token (dari QR)</label><input id="tokenInput" class="form-control"></div>
          <button class="btn btn-primary" id="manualSubmit">Kirim</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.7/minified/html5-qrcode.min.js"></script>
<script>
  let html5QrCode = null;
  function startScanner(){
    try{
      if(typeof Html5Qrcode === 'undefined') throw new Error('Html5Qrcode lib not loaded');
      html5QrCode = new Html5Qrcode("reader");
      Html5Qrcode.getCameras().then(cameras => {
        if(cameras && cameras.length){
          const cameraId = cameras[0].id;
          html5QrCode.start(cameraId, { fps: 10, qrbox: 250 }, qrCodeMessage => {
            try{
              const data = JSON.parse(qrCodeMessage);
              sendScan(data.nis, data.token);
            }catch(e){
              $('#tokenInput').val(qrCodeMessage);
            }
          }, err => {})
          .catch(err=>console.error(err));
        }
      }).catch(err=>console.error(err));
    }catch(err){
      console.warn('Scanner not available:', err.message);
      $('#reader').html('<div class="p-3 text-center text-muted">Scanner tidak tersedia — gunakan input manual.</div>');
    }
  }

  $(document).ready(()=>{
    // Ensure sendScan is available even if scanner fails
    function sendScan(nis, token){
      if(!nis || !token){
        Swal.fire('Perhatian','Isi NIS dan Token terlebih dahulu','warning');
        return;
      }
      $.post("{{ route('siswa.scan.store') }}", {_token:'{{ csrf_token() }}', nis:nis, token:token, device:navigator.userAgent})
      .done(res=>{ Swal.fire('Berhasil','Absensi tersimpan','success'); if(html5QrCode) html5QrCode.stop(); })
      .fail(err=>{ Swal.fire('Gagal', err.responseJSON?.error || err.responseText || 'Terjadi kesalahan', 'error'); });
    }

    // Start scanner (if library available)
    startScanner();

    $('#manualForm').on('submit', function(e){ e.preventDefault(); sendScan($('#nisInput').val(), $('#tokenInput').val()); });
  });
</script>
@endpush
