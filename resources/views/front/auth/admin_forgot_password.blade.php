@extends('front.layouts.auth.app')
@section('title','Yönetici Girişi')


@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-md-7">
      <div class="mb-4">
        <h3>Şifre Sıfırlama</h3>
        <p class="mb-4">Şifrenizi sıfırlamak için lütfen mail adresinizi girin.</p>
      </div>
      <form action="{{url('/forgot-password-admin-post')}}" method="post">
        @csrf

        @if(session('error'))
        <div>
          {{ session('error')}}
        </div>
        @endif

        <br>

        <div class="form-group first">
          <input type="email" class="form-control" name="email" placeholder="Mail Adresi" id="email">
        </div><br><br>


        <input type="submit" value="Şifre Al" class="btn btn-block btn-success">


      </form>
    </div>
  </div>
@endsection
