@extends('back.layouts.app')
{{-- title --}}
@section('title','Öğrenci Paneli')
{{-- Header --}}
@section('header')  @include('back.student.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.student.layouts.menu')    @endsection
{{-- Content --}}
@section('content')
    
    <div class="card py-3">
        <div class="card-content collapse show">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="m-0"><b>Danışman Adı</b> {{$detail->teacher_name}}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><b>Danışman E Posta Adresi</b> {{$detail->email}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><b>Proje Bilgileri</b> {{$detail->title}}</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
               <b>{{$detail->created_at}}</b>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="container">
    
                <div class="my-2">
                    <h2>Projenin Meteryal</h2>
                    <p class="m-0">{{$detail->material}}</p>
                </div>
    
                <div class="my-2">
                    <h2>Projenin Amacı</h2>
                    <p class="m-0">{{$detail->goal}}</p>
                </div>
                @if($detail->explain !=null)
                <div class="my-2">
                    <h2>Neden Red Edildi?</h2>
                    <p class="m-0">{{$detail->explain}}</p>
                </div>
                @endif
                <div class="my-2">
                <h2>Projenin Anahtar Kelimeleri</h2>
                <ul class="keys">
                    @foreach ($detail->keys as $key)
                        <li>{{$key['key']}}</li>
                    @endforeach
                </ul>
            </div>

            </div>
        </div>
    </div>
          
@endsection
