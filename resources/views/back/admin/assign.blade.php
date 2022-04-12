@extends('back.layouts.app')
{{-- title --}}
@section('title', 'Yönetici Paneli')
@section('assign', 'open')
{{-- Header --}}
@section('header') @include('back.admin.layouts.header') @endsection
{{-- Menu --}}
@section('menu') @include('back.admin.layouts.menu') @endsection
{{-- Content --}}
@section('content')

    <div class="container">
        @if (isset($table))
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
        
        @else
            <div class="row py-2 mb-2 text-center justify-content-center algin-items-center">

            @if(isset($block))
            <div aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-popup swal2-modal swal2-show"
                tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: flex;">
                <div class="swal2-header">
                    <ul class="swal2-progress-steps" style="display: none;"></ul>
                    <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;"><span
                            class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span
                                class="swal2-x-mark-line-right"></span></span></div>
                    <div class="swal2-icon swal2-question" style="display: none;"></div>
                    <div class="swal2-icon swal2-warning" style="display: none;"></div>
                    <div class="swal2-icon swal2-info" style="display: none;"></div>
                    <div class="swal2-icon swal2-success" style="display: none;">
                        <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                        <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
                        <div class="swal2-success-ring"></div>
                        <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                        <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                    </div><img class="swal2-image" style="display: none;">
                    <h2 class="swal2-title" id="swal2-title" style="display: flex;">Hata!</h2><button type="button"
                        class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
                </div>
                <div class="swal2-content">
                    <div id="swal2-content" style="display: block;">{!! $block !!}</div><input
                        class="swal2-input" style="display: none;"><input type="file" class="swal2-file"
                        style="display: none;">
                    <div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select
                        class="swal2-select" style="display: none;"></select>
                    <div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox"
                        class="swal2-checkbox" style="display: none;"><input type="checkbox"><span
                            class="swal2-label"></span></label>
                    <textarea class="swal2-textarea" style="display: none;"></textarea>
                    <div class="swal2-validation-message" id="swal2-validation-message" style="display: none;"></div>
                </div>
                <div class="swal2-actions" style="display: flex;">
                    <a href="{{ route($route) }}" class="swal2-confirm btn btn-danger" aria-label="" style="display: inline-block;">{{$title}}</a>
                </div>
            </div>
            @else 

                <div class="col-md-6 ">
                    <img src="{{ asset('back') }}/assets/img/rocket.svg" class="img-responsive"
                        style="width:100% !important" alt="">
                </div>
                <div
                    class="col-md-6 align-items-center d-flex flex-column justify-content-center border border-light rounded p-5">
                    Bu işlem ile birlikte {{$period}} dönemine ait sistemde var olan öğrencileri sarısıyla sistemdeki danışman hocalara atıyor
                    olacaksınız. Atama işlemi sonrası bu sayfa da atananların listesi görüntülenecektir. Atama işleminin ardından {{$period}} dönemine öğrenci veya öğretemen eklemezsiniz!
                    <form action="{{ route('admin.assign') }}" class="mt-5" method="post">
                        @csrf
                        <input type="submit" value="Atamayı Başlat" class="btn btn-block btn-success glow">
                    </form>
                </div>

            @endif
            </div>
        @endif
    </div>

@endsection
