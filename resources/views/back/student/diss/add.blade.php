@extends('back.layouts.app')
{{-- title --}}
@section('title','Öğrenci Paneli')
@section('diss','open')

{{-- Header --}}
@section('header')  @include('back.student.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.student.layouts.menu')    @endsection
{{-- Content --}}
@section('content')

<form action="{{route('student.diss.create')}}"  method="post" enctype="multipart/form-data">
@csrf

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h5><b>{{strtoupper($title)}}</b> Başlıklı proje öneriniz için TEZ yükleme alanı</h5>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-body d-flex gap-3 justify-content-between py-1">
                <div>
                    <label for="">PDF Dosyası</label>
                    <input type="file" class="form-control" name="file[]" width="100%" accept=".pdf" required>
                </div>
                <div>
                    <label for="">Word Dosyası</label>
                    <input type="file" class="form-control" name="file[]" width="100%" accept=".docx" required>
                </div>
            </div>
        </div>
    </div>

<button type="submit" class="btn btn-primary mb-5">Tezleri Kaydet</button>

</form>


@endsection

{{-- Page Js --}}


{{-- Page CSS --}}
@section('page.css')
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/forms/tags/tagging.css">
@stop
