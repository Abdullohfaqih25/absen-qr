<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">AbsensiQR</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        @auth
          @if(auth()->user()->isAdmin())
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
          @elseif(auth()->user()->isGuru())
            <li class="nav-item"><a class="nav-link" href="{{ route('guru.qr.show') }}">Guru</a></li>
          @else
            <li class="nav-item"><a class="nav-link" href="{{ route('siswa.scan') }}">Scan QR</a></li>
          @endif
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-link nav-link">Logout</button></form>
          </li>
        @endauth
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
