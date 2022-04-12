@extends('front.layouts.auth.app')

@section('title','Öğrenci Girişi')


@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-md-7">
      <div class="mb-4">
        <h3>Giriş Yap</h3>
        <p class="mb-4">Projenizin takibini yapmak için lütfen giriş yapınız.</p>
      </div>
      <x-response />
      <form action="{{route('check.student')}}" method="post">
        @csrf

        @if(session('success'))
        <div>
          {{ session('success')}}
        </div>
        @endif

        <br>

        <div class="form-group first">
          <input type="text" class="form-control" name="student_number" placeholder="Öğrenci Numarası" maxlength="9" id="username">

        </div>
        <div class="form-group last mb-3">
          <input type="password" class="form-control" name="password" placeholder="Parola"  id="password">

        </div>

        <div class="d-flex mb-5 align-items-center">
          <span class="ml-auto"><a href="{{url('/forgot-password-student')}}" class="forgot-pass">Parolamı unuttum</a></span>
        </div>

        <input type="submit" value="Giriş Yap" class="btn btn-block btn-success">


      </form>
    </div>
  </div>
@endsection
