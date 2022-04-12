@extends('back.layouts.app')
{{-- Header --}}
@section('title','Öğrenci Paneli')
@section('home','open')

{{-- Header --}}
@section('header')  @include('back.student.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.student.layouts.menu')    @endsection

{{-- content --}}
@section('content')
<div class="row d-flex justify-content-center mb-5 text-center">
    <h1>Aktif Dönem</h1>
    <h2>{{isset($period)? $period : 'Oluşturulmadı!'}}</h2>
</div>

<div class="row">
    <p>Merhaba Sn. {{$user_name}}, KOUP paneline hoş geldiniz. Son gelişmeleri aşağıda görüntüleyebilirsiniz.</p>
    </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-12">
                        <div class="card rounded-20">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    @if($teacher!=null)
                                    <div class="p-2 text-center bg-primary bg-darken-2">
                                        <img src="{{asset('user_picture/teachers').'/'.$teacher->picture}}" class="img-responsive teacher-img" width="50px" height="50px"  alt="">
                                    </div>
                                    <div class="p-2 bg-gradient-x-primary white media-body">
                                        <h5>Danışmanımın Bilgileri</h5>
                                        <h5 class="text-bold-400 mb-0"><i class="feather icon-arrow-right"></i> {{$teacher->name}}</h5>
                                        <h5 class="text-bold-400 mb-0"><i class="feather icon-arrow-right"></i> {{$teacher->email}}</h5>
                                    </div>
                                    @else
                                    <div class="p-2 bg-gradient-x-primary white media-body">
                                        <h5>Danışman Atanmamış</h5>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Stats -->

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-12">
                        <div class="card rounded-20">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 bg-gradient-x-primary white media-body student-status">
                                        <h2>Öneri</h2>
                                        <span>{{$project}}</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-12">
                        <div class="card rounded-20">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 bg-gradient-x-primary white media-body student-status">
                                        <h2>Rapor</h2>
                                        <span>{{$report}}</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-12">
                        <div class="card rounded-20">
                            <div class="card-content">
                                <div class="media align-items-stretch">
                                    <div class="p-2 bg-gradient-x-primary white media-body student-status">

                                        <h2>Tez</h2>
                                        <span>{{$diss}}</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

@endsection

