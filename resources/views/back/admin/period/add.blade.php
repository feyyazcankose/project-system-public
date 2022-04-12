@section('period','open')

@extends('back.layouts.app')
{{-- title --}}
@section('title','Yönetici Paneli')

{{-- Header --}}
@section('header')  @include('back.admin.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.admin.layouts.menu')    @endsection
{{-- Content --}}
@section('content')
<div class="card">
    <div class="card-content">
        <div class="card-body">
<x-form :form=$form />
        </div>
    </div>
</div>
@endsection