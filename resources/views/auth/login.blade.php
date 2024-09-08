@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
<div class="brand-logo text-center pt-5">
  <h3>Form Login</h3>

  @if (session()->has('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
  @endif

</div>
<form class="pt-3" method="POST" action="{{ route('login') }}">
  @csrf
  <div class="form-group">
    <input id="username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">
    @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required placeholder="Password">
    @error('password')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>
  <div class="mt-3">
    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Login</button>
  </div>

  <div class="text-center mt-4 font-weight-light">
    Belum punya akun <a href="/register" class="text-primary">Registrasi</a>
  </div>

  <div class="text-center mt-4 font-weight-light">
    Lupa password <a href="https://wa.me/6282127476721?text=Halo%20Admin%2C%20saya%20meminta%20bantuan%20Anda%20untuk%20mengganti%20kata%20sandi%20saya.%20Berikut%20ini%20adalah%20detail%20yang%20perlu%20diubah%3A%0A%0AUsername%3A%20%0APassword%20baru%3A%20%0A%0ATerima%20kasih%20atas%20bantuannya." target="_blank" class="text-primary">Hubungi Admin</a>
  </div>

</form>
@endsection