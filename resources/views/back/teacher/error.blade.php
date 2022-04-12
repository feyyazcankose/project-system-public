@extends('back.layouts.app')
{{-- title --}}
@section('title','Danışman Paneli')
{{-- Header --}}
@section('header')  @include('back.teacher.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.teacher.layouts.menu')    @endsection

{{-- content --}}
@section('content')
    @php $error=session('error'); @endphp
    <div class="container">
    @if($error!=null)
    <div class="row py-2 mb-2 text-center justify-content-center algin-items-center">
    <div aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-popup swal2-modal swal2-show"
        tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: flex;">
        <div class="swal2-header">
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
                class="swal2-close" aria-label="Close this dialog"
                style="display: none;">
        </div>
        <div class="swal2-content">
            <div id="swal2-content" style="display: block;">
                {!! $error['explain'] !!}
            </div>
        </div>
        @if(isset($error['route']))
        <div class="swal2-actions" style="display: flex;">
            <a href="{{route($error['route'])}}" class="swal2-confirm btn btn-danger" aria-label=""
                style="display: inline-block;">{!! $error['button'] !!}</a>
        </div>
        @endif
    </div>
    </div>
    @endif
</div>
@endsection
