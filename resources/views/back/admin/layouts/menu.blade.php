<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
   
    <li class=" navigation-header"><span>Yönetici Paneli</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="admins"></i>
    </li>
 <br>
     <li class="nav-item @yield('home')"><a href="{{route('admin.home')}}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Son Durum</span></a> </li>
    <li class=" nav-item @yield('period')"><a href="#"><i class="icon-fire"></i><span class="menu-title" data-i18n="öğrenci işlemleri">Dönem İşlemleri</span></a>
        <ul class="menu-content">
            <li><a class="menu-item" href="{{route('admin.period')}}" data-i18n="Öğrenci Kayıt">Dönem Kayıt</a>
            </li>
            <li><a class="menu-item" href="{{route('admin.period.list')}}" data-i18n="Öğrenci Listesi">Dönem Listesi</a>
            </li>

        </ul>
    </li>

    <li class=" nav-item  @yield('student')"><a href="#"><i class="icon-graduation"></i><span class="menu-title" data-i18n="öğrenci işlemleri">Öğrenci İşlemleri</span></a>
        <ul class="menu-content">
            <li><a class="menu-item" href="{{route('admin.student.add')}}" data-i18n="Öğrenci Kayıt">Öğrenci Kayıt</a>
            </li>
            <li><a class="menu-item" href="{{route('admin.student.list')}}" data-i18n="Öğrenci Listesi">Öğrenci Listesi</a>
            </li>

        </ul>
    </li>
    <li class=" nav-item  @yield('teacher')"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Danışman işlemleri">Danışman İşlemleri</span></a>
        <ul class="menu-content">
            <li><a class="menu-item" href="{{route('admin.teacher.add')}}" data-i18n="Danışman Kayıt">Danışman Kayıt</a>
            </li>
            <li><a class="menu-item" href="{{route('admin.teacher.list')}}" data-i18n="Danışman Listesi">Danışman Listesi</a>
            </li>

        </ul>
    </li>
    <li class=" nav-item  @yield('admin')"><a href="#"><i class="icon-key"></i><span class="menu-title" data-i18n="Yönetici işlemleri">Yönetici İşlemleri</span></a>
        <ul class="menu-content">
            <li><a class="menu-item" href="{{route('admin.admin.add')}}" data-i18n="Yönetici Kayıt">Yönetici Kayıt</a>
            </li>
            <li><a class="menu-item" href="{{route('admin.admin.list')}}" data-i18n="Yönetici Listesi">Yönetici Listesi</a>
            </li>

        </ul>
    </li>
        <li class=" nav-item  @yield('assign')"><a href="{{route('admin.assign.page')}}"><i class="feather icon-grid"></i><span class="menu-title" data-i18n="Proje işlemleri">Görevlendirme</span></a>
        </li>
    <li class=" nav-item  @yield('project')"><a href="#"><i class="icon-bulb"></i><span class="menu-title" data-i18n="Proje işlemleri">Proje İşlemleri</span></a>
        <ul class="menu-content">
            <li><a class="menu-item" href="{{route('admin.project.list')}}" data-i18n="Onaylanan Projeler">Projeleri Görüntüle</a>
            </li>

        </ul>
    </li>
   
    <li class=" nav-item  @yield('report')"><a href="#"><i class="icon-doc"></i><span class="menu-title" data-i18n="Rapor işlemleri">Rapor İşlemleri</span></a>
        <ul class="menu-content">
            <li><a class="menu-item" href="{{route('admin.report.list')}}" data-i18n="Kullanıcı Kayıt">Rapor Görüntüle </a>
            </li>

        </ul>
    </li>
    <li class=" nav-item  @yield('diss')"><a href="#"><i class="feather icon-file-text"></i><span class="menu-title" data-i18n="Rapor işlemleri">Tez İşlemleri</span></a>
        <ul class="menu-content">
            <li><a class="menu-item" href="{{route('admin.diss.list')}}" data-i18n="Kullanıcı Kayıt">Tezleri Görüntüle</a>
            </li>

        </ul>
    </li>
    <br><br>
    
    <li class="nav-item @yield('profile')"><a href="{{route('admin.profile')}}"><img src="{{asset('user_picture/admins').'/'.Session()->get('user')->picture}}" alt="" class="menu-profile"><span class="menu-title" data-i18n="Account setting">Hesabım</span></a>
    </li>
    <li class=" nav-item  "><a href="{{route('logout')}}"><i class="icon-close"></i><span class="menu-title" data-i18n="Rapor işlemleri">Çıkış Yap</span></a>
    </li>

</ul>