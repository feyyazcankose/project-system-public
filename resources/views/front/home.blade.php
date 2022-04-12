@extends('front.layouts.app')

@section('content')
     <!-- Mashead header-->
     <header class="masthead">
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6">
                    <!-- Mashead text and app badges-->
                    <div class="mb-5 mb-lg-0 text-center text-lg-start">
                        <h1 class="display-1 lh-1 mb-3">Kocaeli Üniversitesi Paneli</h1>
                        <p class="lead fw-normal text-muted mb-5">Yazılım geliştirme ödevi olarak verilen kocaeli üniversite geliştirem paneli. Laravel kullanıldı</p>
                        <div class="d-flex flex-column flex-lg-row align-items-center">
                            <a class="me-lg-3 mb-4 mb-lg-0 btn btn-primary" href="{{ route('login.student') }}"  style="border:none; border-radius:20px;">Öğrenci Girişi</a>
                            <a href="{{ route('login.teacher') }}" class="btn btn-primary" style="border:none;border-radius:20px;">Öğretmen Girişi</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    
                    <img src="{{asset('front')}}/assets/img/1463.png" width="500" height="300" alt="">
                </div>
            </div>
        </div>
    </header>
    <!-- Quote/testimonial aside-->
    <aside class="text-center bg-gradient-primary-to-secondary">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-xl-8">
                    <div class="h2 fs-1 text-white mb-4">"Öğrencilerin proje konusu önermesi, kabul ettirmesi, projeyi raporlaştırması ve tez haline getirmesini düzenleyen web tabanlı bir Proje Takip Sistemi."</div>
                   
                </div>
            </div>
        </div>
    </aside>
    <!-- App features section-->
    <section id="features">
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-8 order-lg-1 mb-5 mb-lg-0">
                    <div class="container-fluid px-5">
                        <div class="row gx-5">
                            <div class="col-md-6 mb-5">
                                <!-- Feature item-->
                                <div class="text-center">
                                    <i class="bi-phone icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Mobile Uyumlu</h3>
                                    <p class="text-muted mb-0">Responsive tasarımımızla mobil telefonlara uygun web sitesi!</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <!-- Feature item-->
                                <div class="text-center">
                                <i class="bi-patch-check icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Kolay Kullanılabilir </h3>
                                    <p class="text-muted mb-0">İçeriden yönlendirmelerle kolayca kullanılabilir!</p>
                                </div>
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="col-lg-4 order-lg-0">
                <img src="{{asset('front')}}/assets/img/1463.png" width="500" height="300" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Basic features section-->
    <section class="bg-light">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center justify-content-lg-between">
                <div class="col-12 col-lg-5">
                    <h2 class="display-4 lh-1 mb-4">Eğitime Katkıyı Önemsiyoruz</h2>
                    <p class="lead fw-normal text-muted mb-5 mb-lg-0">Öğretmenler! Yeni nesli, cumhuriyetin fedakâr öğretmen ve eğitimcileri, sizler yetiştireceksiniz. Ve yeni nesil, sizin eseriniz olacaktır. Eserin kıymeti, sizin maharetiniz ve fedakârlığınız derecesiyle orantılı bulunacaktır. Cumhuriyet; fikren, ilmen, fennen, bedenen kuvvetli ve yüksek karakterli koruyucular ister! Yeni nesli, bu özellik ve kabiliyette yetiştirmek sizin elinizdedir... Sizin başarınız, Cumhuriyetin başarısı olacaktır.</p>
                </div>
                <div class="col-sm-8 col-md-6">
                    <div class="px-5 px-sm-0"><img class="img-fluid rounded-circle" src="https://www.pidekorasyon.com/img/products/yt0136-yuvarlak-cam-tablo-kirilmaz-ev-dekorasyonu-2_24.05.2021_11669b4.jpg" alt="..." /></div>
                </div>
            </div>
        </div>
    </section>
   


@endsection