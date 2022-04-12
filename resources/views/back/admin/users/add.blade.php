@extends('back.layouts.app')
@section($open,'open')

{{-- title --}}
@section('title','Yönetici Paneli')
{{-- Header --}}
@section('header')  @include('back.admin.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.admin.layouts.menu')    @endsection
{{-- Content --}}
@section('content')

@if(isset($period))
<div class="my-3 text-center">
    <h1><b>{{$title}}</b></h1>
    <p>{{$period}}</p>
</div>
@endif

<div class="users-list-filter px-1">
    <div class="row border border-light rounded py-2 mb-2 text-center justify-content-center">
        <div class="col-5 col-sm-6 col-lg-3 d-flex align-items-center float-right">
            <button class="btn btn-block btn-success glow" data-toggle="modal" data-target="#AddExcelModal"><i class="d-md-none d-block feather icon-plus white"></i>
                <span class="d-md-block d-none"><i class="feather icon-file-plus mr-2 "></i>Excelden Aktar</span></button>
        </div>
        @if(isset($system_ex))
        <div class="col-5 col-sm-6 col-lg-3 d-flex align-items-center float-right">
                <a href={{route($system_ex)}} class="btn btn-success"><i class="fa fa-database mr-2 "></i> Sistemden Aktar</a>
            </div>
        @endif
    </div>
    <div class="row  py-2 mb-2 text-center justify-content-center" style="diplay:flex">
        <div class="col-md-4"><b>Veya</b></div>        
    </div>
    <div class="modal fade" id="AddExcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <section class="contact-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">{{$excel->title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <x-form :form=$excel />
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <x-form :form=$form />
            </div>
        </div>
    </div>
@endsection