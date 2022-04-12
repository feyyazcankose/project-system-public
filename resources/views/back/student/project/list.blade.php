@extends('back.layouts.app')
{{-- title --}}
@section('title','Öğrenci Paneli')
@section('project','open')
{{-- Header --}}
@section('header')  @include('back.student.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.student.layouts.menu')    @endsection
{{-- Content --}}
@section('content')

<section class="users-list-wrapper">
    @if(isset($system_ex) || isset($form) || isset($excel))
    <div class="users-list-filter px-1">
        <div class="row border border-light rounded py-2 mb-2 text-center justify-content-center">
             @if(isset($form) )
            <div class="col-5 col-sm-6 col-lg-3 d-flex align-items-center">
                <button class="btn btn-block btn-success glow" data-toggle="modal" data-target="#AddContactModal"><i class="d-md-none d-block feather icon-plus white"></i>
                <span class="d-md-block d-none"><i class="fa fa-plus-circle mr-2 "></i>{{$form->title}}</span></button>
            </div>
            <div class="modal fade text-align-start" style="text-align:start !important;" id="AddContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <section class="contact-form">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">{{$form->title}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <x-form :form=$form/>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            @endif
            @if(isset($excel) )
            <div class="col-5 col-sm-6 col-lg-3 d-flex align-items-center float-right">
                <button class="btn btn-block btn-success glow" data-toggle="modal" data-target="#AddExcelModal"><i class="d-md-none d-block feather icon-plus white"></i>
                    <span class="d-md-block d-none"><i class="fa fa-file-excel-o mr-2 "></i>Excelden Aktar</span></button>
            
                
            </div>
            <div class="modal fade text-align-start" style="text-align:start !important;" id="AddExcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
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
            @endif


            @if(isset($system_ex))
            <div class="col-5 col-sm-6 col-lg-3 d-flex align-items-center float-right">
                    <a href={{route($system_ex)}} class="btn btn-success"><i class="fa fa-database mr-2 "></i> Sistemden Aktar</a>
                </div>
            @endif
        </div>

    </div>

    @endif
    @if(isset($error))
    <div class="alert alert-danger">
        {{$error}}
    </div>
    @endif

    <div class="users-list-table">
        <div class="card">
          
            <div class="card-content">
                <div class="card-body">
                    <!-- datatable start -->
                    <div class="table-responsive">
                        <x-table :table=$table />
                    </div>
                    <!-- datatable ends -->
                </div>
            </div>
        </div>  
    </div>

    
</section>

@endsection