@extends('back.layouts.app')
{{-- Header --}}
@section('profile','open')

@section('header')  @include('back.student.layouts.header') 
<style>
        .profile-pic-wrapper {

            width: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .pic-holder {
            text-align: center;
            position: relative;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .pic-holder .pic {
            height: 100%;
            width: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            -o-object-position: center;
            object-position: center;
        }

        .pic-holder .upload-file-block,
        .pic-holder .upload-loader {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(90, 92, 105, 0.7);
            color: #f8f9fc;
            font-size: 12px;
            font-weight: 600;
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .pic-holder .upload-file-block {
            cursor: pointer;
        }

        .pic-holder:hover .upload-file-block,
        .uploadProfileInput:focus~.upload-file-block {
            opacity: 1;
        }

        .pic-holder.uploadInProgress .upload-file-block {
            display: none;
        }

        .pic-holder.uploadInProgress .upload-loader {
            opacity: 1;
        }

        /* Snackbar css */
        .snackbar {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 14px;
            transform: translateX(-50%);
        }

        .snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

    </style>

@endsection
{{-- Menu --}}
@section('menu')    @include('back.student.layouts.menu')    @endsection
<link rel="stylesheet" type="text/css" href="/public/back/app-assets/css/pages/page-users.css">
{{-- content --}}
@section('content')

<div class="content-overlay"></div>

        <div class="content-header row">

        </div>
        <div class="content-body">

            <!-- users edit start -->
            <section class="users-edit">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <ul class="nav  mb-2" role="tablist">
                                <li class="nav-item">
                                    <a class="tab-btn d-flex align-items-center active" id="account-tab" data-toggle="tab"
                                        href="#account" aria-controls="account" role="tab" aria-selected="true">
                                        <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Hesap

                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                        <a class="tab-btn d-flex align-items-center" id="Sifre-tab" data-toggle="tab" href="#Sifre" aria-controls="Sifre" role="tab" aria-selected="false">
                                            <i class="feather icon-info mr-25"></i><span class="d-none d-sm-block">Şifre</span>
                                        </a>
                                    </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <!-- users edit media object start -->

                                    <!-- users edit media object ends -->
                                    <!-- users edit account form start -->
                                    <form method="POST" action="{{ route('student.profilUpdate') }}" enctype="multipart/form-data">
                                        @csrf
                                        {{-- <div class="profile-pic-wrapper">
                                            <div class="pic-holder">
                                                <!-- uploaded pic shown here -->
                                                <img id="profilePic" class="pic" src="{{ asset('back') }}/{{ $ProfilFoto }}">

                                                {{-- <input class="uploadProfileInput" type="file" name="picture"
                                                    id="newProfilePhoto"  />
                                                <label for="newProfilePhoto" class="upload-file-block">
                                                    <div class="text-center">
                                                        <div class="mb-2">
                                                            <i class="fa fa-camera fa-2x"></i>
                                                        </div>
                                                        <div class="text-uppercase">
                                                            Fotoğrafı <br /> Güncelle
                                                        </div>
                                                    </div>
                                                </label> 
                                               
                                            </div>


                                        </div> --}}
                                        <div class="row">
                                        <div class="card-body">
                                               
                                            </div>
                                            <div class="col-md-12 mb-3">
                                              <label for="">Fotoğraf Yükle</label>
                                                <input type="file" name="file" class="form-control">
                                            </div>
                                                    <div class="col-md-12">
                                                            <div class="form-group">
                                                                    <label class="text-center">Okul No</label>
                                                                        <input type="text"  readonly disabled class="form-control" value="{{ $OkulNo }}"
                                                                            >

                                                                    </div>
                                                        </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>Ad Soyad</label>
                                                        <input type="text" class="form-control" placeholder="Username"
                                                            value="{{ $Adsoyad }}" name="name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Fakülte</label>
                                                    <input type="text" name="faculty" readonly class="form-control" value="{{ $Fakulte }}" >
                                                </div>
                                                <div class="form-group">
                                                    <label>TCKNO</label>
                                                    <input type="text" name="tc" maxlength="11" class="form-control" value="{{ $Tc }}" >
                                                </div>
                                             
                                            </div>
                                            <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                    <div class="controls">
                                                        <label>E-mail</label>
                                                        <input type="email" class="form-control" placeholder="Email"
                                                            value="{{ $Email }}" name="email">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Üniversite</label>
                                                    <input type="text" name="university" readonly class="form-control" value="{{ $Universite }}"
                                                        >

                                                </div>
                                                <div class="form-group">
                                                    <label>Telefon No</label>
                                                    <input type="text" name="phone_number" maxlength="15" class="form-control" value="{{ $Tel }}"
                                                        >

                                                </div>
                                           

                                            </div>
                                          
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <button type="submit"
                                                    class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Kaydet</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit account form ends -->
                                </div>
                                <div class="tab-pane" id="Sifre" aria-labelledby="Sifre-tab" role="tabpanel">
                                        <!-- users edit Info form start -->
                                        <form method="POST" action="{{route('student.changePassword')}}">
                                            @csrf
                                          
                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-3"></div>
                                                    <div class="col-6">
                                                  
                                                    <label>Eski Şifre</label>
                                                    <input type="password" name="old_password" required class="form-control" placeholder="Eski şifreniz">
                                                    @error('old_password')
<span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-3"></div>
                                                </div>
                                                <div class="row">
                                                <div class="col-3"></div>
                                                    <div class="col-6 mt-2">
                                                   
                                                    <label>Yeni Şifre</label>
                                                    <input type="password" name="new_password"  required class="form-control" placeholder="Yeni şifreniz"
                                                        >

                                                </div>
                                                <div class="col-3"></div>
                                                </div>
                                                <div class="row">
                                                <div class="col-3"></div>
                                                    <div class="col-6 mt-2">
                                                  
                                                    <label>Yeni Şifre Tekrarı</label>
                                                    <input type="password"  name="new_password_confirmation" required class="form-control"  placeholder="Yeni şifre tekrarı">

                                               
                                                    </div>
                                                    <div class="col-3"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2 d-flex flex-sm-row flex-column justify-content-center mt-1">
                                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Değiştir
                                                       </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- users edit Info form ends -->
                                    </div>                 
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- users edit ends -->
        </div>




@endsection
