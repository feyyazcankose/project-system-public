@extends('back.layouts.app')
{{-- title --}}
@section('title','Öğretmen Paneli')
@section('diss','open')
{{-- Header --}}
@section('header') @include('back.teacher.layouts.header') @endsection
{{-- Menu --}}
@section('menu') @include('back.teacher.layouts.menu') @endsection
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
                                    <th>Öğrenci Adı</th>
                                    <th>Tez Durumu</th>
                                    <th>PDF</th>
                                    <th>WORD</th>
                                    <th>Onayla</th>
                                    <th>Red</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td class="{{$item->class}}">{{$item->period_title}}</td>
                                    <td class="{{$item->class}}">{{$item->title}}</td>
                                    <td class="{{$item->class}}">{{$item->student_name}}</td>
                                    <td class="{{$item->class}}">{{$item->case}}</td>
                                    <td><a href="{{asset('documents_diss_').$item->pdf_url}}" class="{{$item->class}}" target="_blank">Dosya</a></td>
                                    <td><a href="{{asset('documents_diss_').$item->word_url}}" class="{{$item->class}}" target="_blank">Dosya</a></td>
                                    <td class="{{isset($item['class'])  ? $item['class'] : ''}}">
                                        @if(!is_array($item->btn))
                                        <a href="{{route("teacher.diss.up.approve",$item->id)}}" class="btn btn-primary">Onayla</a>
                                        @else
                                        {{$item->btn[1]}}
                                        @endif
                                    </td>
                                    <td class="{{isset($item['class'])  ? $item['class'] : ''}}">
                                        @if(!is_array($item->btn))
                                        <a href="{{route("teacher.diss.explain",$item->id)}}" class="btn btn-danger">Red</a>
                                        @else
                                        {{$item->btn[1]}}
                                        @endif
                                    </td>
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

@section('page.js')
<script src="{{asset('back/assets/js/form.js')}}" type="text/javascript"></script>
@stop