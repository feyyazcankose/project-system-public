@extends('back.layouts.app')
{{-- title --}}
@section('title','Yönetici Paneli')
@section('diss','open')
{{-- Header --}}
@section('header')  @include('back.admin.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.admin.layouts.menu')    @endsection
{{-- Content --}}
@section('content')

<section class="users-list-wrapper">
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
                            <table id="users-list-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th>Dönem</th>
                                        <th>Proje Başlığı</th>
                                        <th>Tez Durumu</th>
                                        <th>Öğrenci Adı</th>
                                        <th>Öğrenci Numarası</th>
                                        <th>Danışman Adı</th>
                                        <th>Danışman Sicil No</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($items as $item)
                                    <tr class="{{$item->class}}">
                                        <td>{{$item->period_title}}</td>
                                        <td>{{$item->project_title}}</td>
                                        <td>{{$item->durum}}</td>                                        
                                        <td>{{$item->student_name}}</td>
                                        <td>{{$item->student_number}}</td>
                                        <td>{{$item->teacher_name}}</td>
                                        <td>{{$item->sicil}}</td>
                                    </tr>
                                        @endforeach
                                           
                                </tbody>
                            </table>
                    </div>
                    <!-- datatable ends -->
                </div>
            </div>
        </div>  
    </div>

    
</section>

@endsection

