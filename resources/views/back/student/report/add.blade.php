@extends('back.layouts.app')
{{-- title --}}
@section('title','Öğrenci Paneli')
@section('report','open')

{{-- Header --}}
@section('header')  @include('back.student.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.student.layouts.menu')    @endsection
{{-- Content --}}
@section('content')

<form action="{{route('student.report.create')}}" enctype="multipart/form-data" method="post" >
@csrf

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h5><b>{{strtoupper($title)}}</b> Başlıklı proje öneriniz için rapor yükleme alanı</h5>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5><b>3 adet PDF uzantılı rapor yükleyin</b></h5>
        </div>
        <div class="card-content">
            <div class="card-body d-flex gap-3 py-1">
                <div>
                    <label for="">1. PDF Dosyası</label>
                    <input type="file" class="form-control" name="file[]" accept=".pdf" >
                </div>
                <div>
                    <label for="">2. PDF Dosyası</label>
                    <input type="file" class="form-control" name="file[]" accept=".pdf" >
                </div>
                <div>
                    <label for="">3. PDF Dosyası</label>
                    <input type="file" class="form-control" name="file[]" accept=".pdf" >
                </div>
            </div>
        </div>
    </div>

   <div class="card my-3">
    <div class="card-header">
        <h5><b>3 adet DOCX uzantılı rapor yükleyin</b></h5>
    </div>
    <div class="card-content">
        <div class="card-body d-flex gap-3 py-1">
            <div>
                <label for="">1. Word Dosyası</label>
                <input type="file" class="form-control" name="file[]" accept=".docx" >
            </div>
            <div>
                <label for="">2. Word Dosyası</label>
                <input type="file" class="form-control" name="file[]" accept=".docx" >
            </div>
            <div>
                <label for="">3. Word Dosyası</label>
                <input type="file" class="form-control" name="file[]" accept=".docx" >

            </div>
        </div>
    </div>
   </div>
<button type="submit" class="btn btn-primary mb-5">Raporları Kaydet</button>

</form>


@endsection

{{-- Page Js --}}


{{-- Page CSS --}}
@section('page.css')
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/forms/tags/tagging.css">
@stop
