@extends('layouts.auth')


@section('content') 
<div class="brand-logo text-center mt-5">
  <h3>Form Registrasi</h3>
</div>

@if (session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  </div>
@endif

<form class="pt-3" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
  @csrf

  <div class="form-group">
    <input id="nama" type="text" class="form-control form-control-lg @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autofocus placeholder="Nama">
    @error('nama')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  
  <div class="form-group">
    <input id="nim" type="text" class="form-control form-control-lg @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required autofocus placeholder="NIM">
    @error('nim')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>

  <div class="form-group">
    <input id="username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required placeholder="Username">
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

  <div class="form-group">
    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required placeholder="Konfirmasi Password">
  </div>

  <div class="form-group row">
    <div class="col-sm">
      <input type="file" name="ktm" class="file-upload-default" id="ktm">
      <div class="input-group col-xs-12">
        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload KTM">
        <span class="input-group-append">
          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
        </span>
      </div>
    </div>
    @error('ktm')
      <p class="text-danger">{{ $message }}</p>
    @enderror
  </div>

  <div class="mt-3">
    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Register</button>
  </div>

  <div class="text-center mt-4 font-weight-light">
    Sudah Punya Akun <a href="/login" class="text-primary">Login</a>
  </div>
</form>

@endsection
