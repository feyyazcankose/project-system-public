@extends('back.layouts.app')
{{-- title --}}
@section('title','Yönetici Paneli')
{{-- Header --}}
@section('header')  @include('back.admin.layouts.header')  @endsection
{{-- Menu --}}
@section('menu')    @include('back.admin.layouts.menu')    @endsection
{{-- Content --}}
@section('content')

@if(isset($active_period))
<div class="my-3 text-center">
    <h2><b>Aktif Dönem: {{$active_period}}</b></h2>
    <p>Sisteme kayıtlı dönemlerden aktif döneme ({{$active_period}}) kullanıcı eklemek için lütfen kullanıcıları seçin.</p>

</div>
@endif
              
                <div class="users-list-table">
                    <div class="card">
                      
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <form action="{{route('admin.teacher.system.create')}}" method="post" >
                                        @csrf
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th >
                                                  <input type="checkbox" class="form-check-input checkbox" onclick="tumuCheked()" id="tumu">
                                                </th>
                                                <th scope="col">Danışman Adı Soyadı</th>
                                                <th scope="col">Danışman Sicil Numarası</th>
                                                <th scope="col">Danışmanın Kayıtlı Dönemleri</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($items as $item)
                                            <tr>
                                                <th scope="row">
                                                    <input type="checkbox" name="check[]"  value="{{$item['id']}}" class="form-check-input checkbox"  onclick="disab()" id="">
                                                </th>
                                                <td>{{$item['name']}}</td>
                                                <td>{{$item['sicil']}}</td>
                                                <td>
                                                @foreach ($item['periods'] as $period)
                                                    <li>{{$period}}</li>
                                                @endforeach
                                                </td>
                                            </tr>    
                                            @endforeach
                                           
                                            
                            
                                            </tbody>
                                          </table>
                                          <div class="eylem">
                                                <div>
                                                    <label for="">Eylem</label><br>
                                                <select class="form-select"  name="durum" id="durum" required onclick="disab()">
                                                    <option  selected>Seçili danışman(lar) için eylem belirleyin</option>
                                                    <option value="add">Danışman(ları) ({{$active_period}}) dönemine ekle</option>
                                                </select>
                                                </div>
                                                <input type="submit" name="submit" id="submit" value="Seçili danışmanları ekle" disabled class="btn btn-primary mt-2" style="display:none">
                                          </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

             
@endsection

@section('page.js')
<script src="{{asset('back/assets/js/form.js')}}" type="text/javascript"></script>

@stop
