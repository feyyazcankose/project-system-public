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

<section class="users-list-wrapper">
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