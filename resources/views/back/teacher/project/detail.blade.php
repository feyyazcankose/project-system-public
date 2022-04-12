@extends('back.layouts.app')
{{-- title --}}
@section('title','Danışman Paneli')
@section('project','open')

{{-- Header --}}
@section('header')  @include('back.teacher.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.teacher.layouts.menu')    @endsection
{{-- Content --}}
@section('content')
    
<div class="card p-3">
    <div class="card-content collapse show">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <p class="m-0"><b>Öğrenci Adı</b> </p>
                    <p>{{$detail->student_name}}</p>
                </div>
                <div class="col-md-3">
                    <p class="m-0"><b>Öğrenci E Posta Adresi</b> </p>
                    <p>{{$detail->email}}</p>
                </div>
                <div class="col-md-3">
                    <p class="m-0"><b>Öğrenci Numarası</b></p>
                    <p> {{$detail->student_number}}</p>
                </div>
                <div class="col-md-3">
                    <p class="m-0"><b>Öğrenci Telefon Numarası</b> </p>
                    <p>{{$detail->phone_number}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-3">
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

@if(isset($similar))
<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="card">
          <div class="card-header"><h4 class="card-title"><b>Benzer anahtarlara sahip projeler</b></h4></div>
            <div class="card-content">
                <div class="card-body">
                    <!-- datatable start -->
                    <div class="table-responsive">
                        <x-table :table=$similar />
                    </div>
                    <!-- datatable ends -->
                </div>
            </div>
        </div>  
    </div>
</section>

@endif


@if(isset($disabled)==null)
<div class="card p-3 mb-4">
    <div class="card-header">
        <h4 class="card-title"><b>Proje Güncelle</b> {{$detail->title}}</h4>
    </div>
    <div class="card-content collapse show">
        <div class="container">
                <a href="{{route('teacher.project.up.approve',$detail->id)}}" value="approve" class="btn btn-primary">Kabul Et</a>
                    <a href="{{route('teacher.project.explain',$detail->id)}}"  value="reject" class="btn btn-danger">Red Et</a>
            </div>
          
        </div>

        </div>
    </div>
</div>
@endif          


@endsection
