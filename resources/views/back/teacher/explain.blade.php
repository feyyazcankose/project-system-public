@extends('back.layouts.app')
{{-- title --}}
@section('title','Öğrenci Paneli')
{{-- Header --}}
@section('header')  @include('back.student.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.student.layouts.menu')    @endsection
{{-- Content --}}
@section('content')

<form action="{{route($route)}}"  method="post" >
@csrf
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h5>Ret etme nedeniniz?</h5>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-body  gap-3 justify-content-between py-1">
                <div>
                    <input type="hidden" value="{{$id}}" name="id">
                    <textarea name="explain" class="form-control" cols="30" rows="5"></textarea>
                </div>
            </div>
        </div>
    </div>

<button type="submit" class="btn btn-primary mb-5">Kaydet</button>

</form>


@endsection

{{-- Page Js --}}


{{-- Page CSS --}}
@section('page.css')
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/forms/tags/tagging.css">
@stop
