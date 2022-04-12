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
            <section class="users-list-wrapper">
                <div class="users-list-filter px-1">
                    <div class="row border border-light rounded py-2 mb-2 text-center justify-content-center">
                        <div class="col-5 col-sm-6 col-lg-3 d-flex align-items-center">
                            <button class="btn btn-block btn-success glow" data-toggle="modal" data-target="#AddContactModal"><i class="d-md-none d-block feather icon-plus white"></i>
                            <span class="d-md-block d-none"><i class="feather icon-plus mr-2 "></i>{{$form->title}}</span></button>
                        </div>
                    </div>

                </div>
                <div class="modal fade" id="AddContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <section class="contact-form">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{$form->title}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <x-form :form=$form/>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="users-list-table">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <!-- datatable start -->
                                <div class="table-responsive">
                                    <form action="{{route('admin.period.active')}}" method="post" id="form">
                                        @csrf
                                        <table id="users-list-datatable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Dönem Adı</th>
                                                    <th>Dönem Başlangıç Tarihi</th>
                                                    <th>Dönem Bitiş Tarihi</th>
                                                    <th>Aktiflik Durumu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($periods))
                                                @foreach ($periods as $period)
                                                <tr>
                                                    <td>{{$period["period_title"]}}</td>
                                                    <td>{{$period["period_date_start"]}}</td>
                                                    <td>{{$period["period_date_end"]}}</td>
                                                    <td>
                                                        <input type="checkbox" onchange="formSubmit(this)"  name="period_add" class="checkbox switchery" value="{{$period["id"]}}"  {{$period["active"] ? 'checked' : '' }} />
                                                    </td>
                                                    
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <!-- datatable ends -->
                            </div>
                        </div>
                    </div>
                </div>

             
            </section>

            <script>
                const checkbox = document.getElementsByClassName('checkbox');
                const form = document.getElementById('form');
                function formSubmit(p){
                    const checkboxs =  [...checkbox];
                    checkboxs.map(function(item){
                        if(item.value==p.value){
                            if(!item.checked)
                            {
                                item.checked=true;
                                item.name="period_dis";
                            }
                        }
                        else
                        item.checked = false;
                    })
    
                
                    form.submit();

                }
            </script>
@endsection

