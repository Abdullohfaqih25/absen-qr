@if(session('success'))
<script>Swal.fire('Sukses','{{ session('success') }}','success');</script>
@endif
