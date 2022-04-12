<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
  
    <li class=" navigation-header"><span>Öğretmen Paneli</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Öğrenci Paneli"></i>
    </li>
    <br>
    <li class="nav-item @yield('home')"><a href="{{route('teacher.home')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Analiz</span></a> </li>
  
        {{-- proje önerileri --}}

    <li class="nav-item @yield('project')"><a href="#!"><i class="feather icon-box"></i><span class="menu-title" data-i18n="Dashboard">Proje Önerileri</span></a> 
        <ul class="menu-content">
            <li class="nav-item"><a href="{{route('teacher.project.list')}}"><span class="menu-title" data-i18n="Dashboard">Tüm Öneriler</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.project.wait')}}"><span class="menu-title" data-i18n="Dashboard">Bekleyen Öneriler</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.project.approve')}}"><span class="menu-title" data-i18n="Dashboard">Onaylanan Öneriler</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.project.reject')}}"><span class="menu-title" data-i18n="Dashboard">Red Edilen Öneriler</span></a> </li>
        </ul>
    </li>

    {{-- raporlar --}}

    <li class="nav-item @yield('report')"><a href="#!"><i class="feather icon-paperclip"></i><span class="menu-title" data-i18n="Dashboard">Raporlar</span></a> 
        <ul class="menu-content">
            <li class="nav-item"><a href="{{route('teacher.report.list')}}"><span class="menu-title" data-i18n="Dashboard">Tüm Raporlar</span></a> </li>

            <li class="nav-item"><a href="{{route('teacher.report.list.detail','wait')}}"><span class="menu-title" data-i18n="Dashboard">Bekleyen Raporlar</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.report.list.detail','approve')}}"><span class="menu-title" data-i18n="Dashboard">Onaylanan Raporlar</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.report.list.detail','reject')}}"><span class="menu-title" data-i18n="Dashboard">Red Edilen Raporlar</span></a> </li>
        </ul>
    </li>

    {{-- tezler --}}

    <li class="nav-item @yield('diss')"><a href="#!"><i class="feather icon-navigation-2"></i><span class="menu-title" data-i18n="Dashboard">Tezler</span></a> 
        <ul class="menu-content">
            <li class="nav-item"><a href="{{route('teacher.diss.list')}}"><span class="menu-title" data-i18n="Dashboard">Tüm Tezler</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.diss.list.detail','wait')}}"><span class="menu-title" data-i18n="Dashboard">Bekleyen Tezler</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.diss.list.detail','approve')}}"><span class="menu-title" data-i18n="Dashboard">Onaylanan Tezler</span></a> </li>
            <li class="nav-item"><a href="{{route('teacher.diss.list.detail','reject')}}"><span class="menu-title" data-i18n="Dashboard">Red Edilen Tezler</span></a> </li>
        </ul>
    </li>

    <li class="nav-item @yield('users')"><a href="{{route('teacher.users')}}"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Account setting">Öğrencilerim</span></a>
    </li>

    <li class="nav-item @yield('profile')"><a href="{{route('teacher.profile')}}"><img src="{{asset('user_picture/teachers').'/'.Session()->get('user')->picture}}" alt="" class="menu-profile"><span class="menu-title" data-i18n="Account setting">Hesabım</span></a>
    </li>
    <li class=" nav-item"><a href="{{route('logout')}}"><i class="feather icon-log-out"></i><span class="menu-title" data-i18n="Rapor işlemleri">Çıkış Yap</span></a>
    </li>
</ul>