<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
    <li class=" navigation-header"><span>Öğrenci Paneli</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Öğrenci Paneli"></i>
    </li>
    <br>
    <li class="nav-item @yield('home')"><a href="{{route('student.home')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Son Durum</span></a> </li>

    {{-- proje önerileri --}}

    <li class="nav-item @yield('project')"><a href="#!"><i class="feather icon-box"></i><span class="menu-title" data-i18n="Dashboard">Proje Önerileri</span></a> 
        <ul class="menu-content">
            <li class="nav-item"><a href="{{route('student.project.list')}}"><span class="menu-title" data-i18n="Dashboard">Öneri Listem</span></a> </li>
            <li class="nav-item"><a href="{{route('student.project.add')}}"><span class="menu-title" data-i18n="Dashboard">Öneri Oluştur</span></a> </li>
        </ul>
    </li>

    {{-- raporlar --}}

    <li class="nav-item @yield('report')"><a href="#!"><i class="feather icon-paperclip"></i><span class="menu-title" data-i18n="Dashboard">Raporlar</span></a> 
        <ul class="menu-content">
            <li class="nav-item"><a href="{{route('student.report.list')}}"><span class="menu-title" data-i18n="Dashboard">Rapor Listem</span></a> </li>
            <li class="nav-item"><a href="{{route('student.report.add')}}"><span class="menu-title" data-i18n="Dashboard">Rapor Oluştur</span></a> </li>
        </ul>
    </li>

    {{-- tezler --}}

    <li class="nav-item @yield('diss')"><a href="#!"><i class="feather icon-navigation-2"></i><span class="menu-title" data-i18n="Dashboard">Tezler</span></a> 
        <ul class="menu-content">
            <li class="nav-item"><a href="{{route('student.diss.list')}}"><span class="menu-title" data-i18n="Dashboard">Taz Listem</span></a> </li>
            <li class="nav-item"><a href="{{route('student.diss.add')}}"><span class="menu-title" data-i18n="Dashboard">Tez Oluştur</span></a> </li>
        </ul>
    </li>

    
    <li class="nav-item @yield('profile')"><a href="{{route('student.profile')}}"><img src="{{asset('user_picture/students').'/'.Session()->get('user')->picture}}" alt="" class="menu-profile"><span class="menu-title" data-i18n="Account setting">Hesabım</span></a>
    </li>
    <li class=" nav-item"><a href="{{route('logout')}}"><i class="feather icon-log-out"></i><span class="menu-title" data-i18n="Rapor işlemleri">Çıkış Yap</span></a>
    </li>
</ul>