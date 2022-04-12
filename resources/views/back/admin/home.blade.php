@extends('back.layouts.app')
{{-- Header --}}
@section('title','Yönetici Paneli')
@section('home','open')
{{-- Header --}}
@section('header')  @include('back.admin.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.admin.layouts.menu')    @endsection

{{-- content --}}
@section('content')

@section('page.css')

@endsection


<div class="row d-flex justify-content-center mb-5 text-center">
    <h1>Aktif Dönem</h1>
    <h2>{{isset($period)? $period : 'Oluşturulmadı!'}}</h2>
</div>
<div class="row">
    <p>Merhaba Sn. {{$user_name}}, KOUP paneline hoş geldiniz. Son gelişmeleri aşağıda görüntüleyebilirsiniz.</p>

</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-12">
        <div class="card rounded-20">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="icon-users font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-primary white media-body">
                        <h5>Sistemde Kayıtlı Öğrenci Sayısı</h5>
                        <h5 class="text-bold-400 mb-0"><i class="feather icon-arrow-right"></i> {{$ogrenciSayisi}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-12">
        <div class="card rounded-20">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="icon-user font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-danger white media-body">
                        <h5>Sistemde Kayıtlı Öğretmen Sayısı</h5>
                        <h5 class="text-bold-400 mb-0"><i class="feather icon-arrow-right"></i>{{$ogretmenSayisi}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

                <!--/ Stats -->
                <!--Product sale & buyers -->
                    <div class="row match-height">
                        <div class="col-xl-4 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 >Son Gelen 5 Öneri</h5>
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <div class=" bg-gradient-x-info white media-body count-item"><span>Toplam</span> {{$projeSayisi}} </div>
                                        </div>
                                    </div>
                                    <div class="card-content px-1">
                                        <div id="recent-buyers" class="media-list height-300 position-relative">
                                        @if($project!=null)
                                            @foreach($project as $item)
        
                                            <a href="#" class="media border-0">
                                                <div class="media-left pr-1">
                                                    <div class="avatar avatar-online avatar-md"><img class="media-object rounded-circle" src={{asset('user_picture/students').'/'.$item->student_picture}} alt="Generic placeholder image">
                                                        <i></i>
                                                    </div>
                                                </div>
                                                <div class="media-body w-100">
                                                    <h6 class="list-group-item-heading">{{$item->student_name}}  ({{$item->project_title}}) </h6>
                                                    <p class="list-group-item-text mb-0"><span class="badge badge-primary">{{$item->durum}} </span></p>
                                                </div>
                                            </a>
        
                                            @endforeach
                                    
                                        
                                            @else
                                            <p>Veri yok.</p>
        
        
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 >Son Gelen 5 Rapor</h5>
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <div class=" bg-gradient-x-info white media-body count-item"><span>Toplam</span> {{$raporSayisi}} </div>
                                        </div>
                                    </div>
                                    <div class="card-content px-1">
                                        <div id="recent-buyers" class="media-list height-300 position-relative">
                                        @if($report!=null)
                                            @foreach($report as $item)
        
                                            <a href="#" class="media border-0">
                                                <div class="media-left pr-1">
                                                    <div class="avatar avatar-online avatar-md"><img class="media-object rounded-circle" src={{asset('user_picture/students').'/'.$item->student_picture}} alt="Generic placeholder image">
                                                        <i></i>
                                                    </div>
                                                </div>
                                                <div class="media-body w-100">
                                                    <h6 class="list-group-item-heading">{{$item->student_name}}  ({{$item->project_title}}) </h6>
                                                    <p class="list-group-item-text mb-0"><span class="badge badge-primary">{{$item->durum}} </span></p>
                                                </div>
                                            </a>
        
                                            @endforeach
                                    
                                            @else
                                            <p>Veri yok.</p>
        
        
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 >Son Gelen 5 Tez</h5>
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <div class=" bg-gradient-x-info white media-body count-item"><span>Toplam</span> {{$tezSayisi}} </div>
                                        </div>
                                    </div>
                                    <div class="card-content px-1">
                                        <div id="recent-buyers" class="media-list height-300 position-relative">
                                            @if($diss!=null)
        
                                        
                                            @foreach($diss as $item)
        
                                            <a href="#" class="media border-0">
                                                <div class="media-left pr-1">
                                                    <div class="avatar avatar-online avatar-md"><img class="media-object rounded-circle" src={{asset('user_picture/students').'/'.$item->student_picture}} alt="Generic placeholder image">
                                                        <i></i>
                                                    </div>
                                                </div>
                                                <div class="media-body w-100">
                                                    <h6 class="list-group-item-heading">{{$item->student_name}}  ({{$item->project_title}}) </h6>
                                                    <p class="list-group-item-text mb-0"><span class="badge badge-primary">{{$item->durum}} </span></p>
                                                </div>
                                            </a>
        
                                            @endforeach
                                            @else
                                            <p>Veri yok.</p>
        
        
                                            @endif
                                        
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
@endsection

@section('jsler')   

<script src="/back/app-assets/vendors/js/extensions/unslider-min.js"></script>
<script src="/back/app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script src="/back/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>

@endsection

