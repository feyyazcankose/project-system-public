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

<form action="{{route('student.project.create')}}"  method="post">
@csrf
{{-- {{ dd(Session()->all()) }} --}}
{{-- {{$data}} --}}
<div class="form-group">
    
   
    
    <fieldset class="form-group">
        <label for="descTextarea">Proje Başlığınız</label>
        <input 
        
        type="text" 
        class="form-control {{Session()->has('title') ? 'error':(isset(Session()->get('success')['title']) ? 'success-input'  : '' )}}" 
        {{Session()->has('title') ? 'autofocus':''}}
        name="title" 
        id="descTextarea"  
        placeholder="Proje Başlığı"
        value="{{ old('title') }}"
        required
        >
        @error('title')
        <div class="alert alert-danger mt-1">{{ $message }}</div>
        @enderror
        @if(isset(Session()->get('success')['title']))
        <div class="ku-alert-success">{!! Session()->get('success')['title'] !!}</div>
        @endif
        
    </fieldset>
    <fieldset class="form-group">
        <label for="descTextarea" >Projenin materyal, yöntem ve araştırma olanakları nelerdir?</label>
        
        <textarea class="form-control {{Session()->has('meterial') ? 'error':(isset(Session()->get('success')['meterial']) ? 'success-input'  : '' )}}" {{Session()->has('meterial') ? 'autofocus':''}}  name="material" id="descTextarea" rows="10" min="200" minlength="200" placeholder="Materyal, yöntem ve araştırma olanakları...." required>{{ old('material') }}</textarea>
        @if (Session()->has('meterial'))
        <div class="ku-alert-danger">{!! Session()->get('meterial') !!}</div>
        @endif

        @error('material')
        <div class="alert alert-danger mt-1">{{ $message }}</div>
        @enderror
        @if(isset(Session()->get('success')['meterial']))
        <div class="ku-alert-success">{!! Session()->get('success')['meterial'] !!}</div>
        @endif

    </fieldset>
    <fieldset class="form-group">
        <label for="descTextarea" >Projenin amacını, önemini ve kapsamı nedir?</label>
        
        <textarea class="form-control {{Session()->has('goal') ? 'error':(isset(Session()->get('success')['goal']) ? 'success-input'  : '' )}}" {{Session()->has('goal') ? 'autofocus':''}} name="goal" id="descTextarea" rows="10"     min="300" minlength="200" placeholder="Projenin amacını, önemini ve kapsamı..." required>{{ old('goal') }}</textarea>
        @if (Session()->has('goal'))
        <div class="ku-alert-danger">{!! Session()->get('goal') !!}</div>
        @endif
        @error('goal')
        <div class="alert alert-danger mt-1">{{ $message }}</div>
        @enderror
        @if(isset(Session()->get('success')['goal']))
        <div class="ku-alert-success">{!! Session()->get('success')['goal'] !!}</div>
        @endif

       
    </fieldset>
    <fieldset class="form-group">
        <label >Lütfen projenizi tanımlayan 5 adet anahtar kelime girin</label>
        @if (Session()->has('error_key'))
        <div class="ku-alert-danger">{!! Session()->get('error_key') !!}</div>
        @endif
        <div class="d-flex gap-2">
        @if (Session()->has('keys'))
            @foreach (Session()->get('keys') as  $key=>$value)
                <input type="text" placeholder="{{++$key}}. Kelime" value="{{$value}}" class="form-control {{isset(Session()->get('success')['keys']) ? 'success-input'  : '' }} {{ Session()->has('key_index') ? (in_array(--$key, Session()->get('key_index')) ? 'error' : '') : '' }}  "name="keys[]" required>
            @endforeach
        @else
        <input type="text" placeholder="1. Kelime" class="form-control"  name="keys[]" required>
        <input type="text" placeholder="2. Kelime" class="form-control"  name="keys[]" required>
        <input type="text" placeholder="3. Kelime" class="form-control"  name="keys[]" required>
        <input type="text" placeholder="4. Kelime" class="form-control"  name="keys[]" required>
        <input type="text" placeholder="5. Kelime" class="form-control"  name="keys[]" required> 
        @endif
       
        </div>
        @error('keys')
        <div class="alert alert-danger mt-1">{{ $message }}</div>
        @enderror
        @if(isset(Session()->get('success')['keys']))
        <div class="ku-alert-success">{!! Session()->get('success')['keys'] !!}</div>
        @endif

        
    </fieldset>
 
</div>

<button type="submit" class="btn btn-primary mb-5">Projeyi Kaydet</button>

</form>


@endsection

{{-- Page Js --}}

@section('page.js')
<script src="{{asset('back')}}/app-assets/js/scripts/forms/tags/tagging.js"></script>
<script src="{{asset('back')}}/app-assets/vendors/js/forms/tags/tagging.min.js"></script>
    <script src="{{asset('back')}}/app-assets/vendors/js/ui/prism.min.js"></script>
@stop

{{-- Page CSS --}}
@section('page.css')
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/forms/tags/tagging.css">
@stop
