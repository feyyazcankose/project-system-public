@extends('back.layouts.app')
{{-- title --}}
@section('title','Öğrenci Paneli')
@section('report','open')

{{-- Header --}}
@section('header') @include('back.student.layouts.header') @endsection
{{-- Menu --}}
@section('menu') @include('back.student.layouts.menu') @endsection
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
                                    <th>Proje Adı</th>
                                    <th>Danışman Adı</th>
                                    <th>Rapor Durumu</th>
                                    <th>1. PDF</th>
                                    <th>2. PDF</th>
                                    <th>3. PDF</th>
                                    <th>1. WORD</th>
                                    <th>2. WORD</th>
                                    <th>3. WORD</th>
                                    <th>Açıklama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr class="{{$item->class}}">
                                    <td>{{$item->period_title}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->teacher_name}}</td>
                                    <td>{{$item->case}}</td>
                                    @foreach ($item->file as $file )
                                    <td><a class="{{$item->class}}" href="{{asset('documents_reports_').$file['file_url']}}" target="_blank">Dosya</a></td>
                                    @endforeach
                                    <td>{{$item->explain!=null ? $item->explain : 'Açıklama yok'}}</td>
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