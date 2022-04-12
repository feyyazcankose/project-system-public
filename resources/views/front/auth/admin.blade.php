@extends('front.layouts.auth.app')
@section('title','Yönetici Girişi')


@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-md-7">
      <div class="mb-4">
        <h3>Giriş Yap</h3>
        <p class="mb-4">Sistemi yönetmek için lütfen giriş yapınız.</p>
      </div>
      <x-response />
      <form action="{{route('check.admin')}}" method="post">
        @csrf

        @if(session('success'))
        <div>
          {{ session('success')}}
        </div>
        @endif

        <br>

        <div class="form-group ">
          <input type="email" class="form-control" name="email" id="email" required placeholder="E posta adresi">

        </div>
        <div class="form-group  mb-3">
          <input type="password" class="form-control" name="password" id="password" required placeholder="Parola">

        </div>

        <div class="d-flex mb-5 align-items-center">
          <span class="ml-auto"><a href="{{url('/forgot-password-admin')}}" class="forgot-pass">Parolamı unuttum</a></span>
        </div>

        <input type="submit" value="Giriş Yap" class="btn btn-block btn-success">


      </form>
    </div>
  </div>

@endsection
