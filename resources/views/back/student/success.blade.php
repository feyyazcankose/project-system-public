@extends('back.layouts.app')
{{-- title --}}
@section('title', 'Öğrenci Paneli')
{{-- Header --}}
@section('header') @include('back.student.layouts.header') @endsection
{{-- Menu --}}
@section('menu') @include('back.student.layouts.menu') @endsection

{{-- content --}}
@section('content')
    @php $success=session('success'); @endphp
    <div class="container">
        @if ($success != null)
        <div class="row py-2  mb-2 text-center justify-content-center algin-items-center">
            <div aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-popup swal2-modal swal2-show"
                tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: flex;">
                <div class="swal2-header">
                    <ul class="swal2-progress-steps" style="display: none;"></ul>
                    <div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span
                                class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div>
                    <div class="swal2-icon swal2-question" style="display: none;"></div>
                    <div class="swal2-icon swal2-warning" style="display: none;"></div>
                    <div class="swal2-icon swal2-info" style="display: none;"></div>
                    <div class="swal2-icon swal2-success swal2-animate-success-icon" style="display: flex;">
                        <div class="swal2-success-circular-line-left" style="background-color: rgba(255, 255, 255, 0);"></div><span
                            class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
                        <div class="swal2-success-ring"></div>
                        <div class="swal2-success-fix" style="background-color: rgba(255, 255, 255, 0);"></div>
                        <div class="swal2-success-circular-line-right" style="background-color: rgba(255, 255, 255, 0);"></div>
                    </div><img class="swal2-image" style="display: none;">
                    <h2 class="swal2-title" id="swal2-title" style="display: flex;">Görev Tamamlandı</h2><button type="button"
                        class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
                </div>
                <div class="swal2-content">
                    <div id="swal2-content" style="display: block;">
                        {!! $success['explain'] !!}
                    </div>
                </div>
                @if(isset($success['route']))
                <div class="swal2-actions" style="display: flex;">
                    <a href="{{route($success['route'])}}" class="swal2-confirm btn btn-success" aria-label=""
                        style="display: inline-block;">{!! $success['button'] !!}</a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection



