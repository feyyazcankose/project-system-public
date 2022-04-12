<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title> @yield('title')</title>
     <link rel="apple-touch-icon" href="{{asset('back')}}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('back')}}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/charts/morris.css">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/extensions/sweetalert2.min.css">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/pages/timeline.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/assets/css/style.css">
    <!-- END: Custom CSS-->
        
  
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/plugins/forms/switch.css"> 
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/vendors/css/forms/toggle/switchery.min.css">
   
    {{-- Page CSS     --}}
    @yield('page.css')
    

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns   " data-open="click" data-menu="vertical-menu" data-col="2-columns">


    
     <!-- BEGIN: Main Menu-->
     <div class="main-menu top-0 menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content py-5">
            @yield('menu')
        </div>
    </div>

    <!-- END: Main Menu-->



                <!-- BEGIN: Content-->
                <div class="app-content content">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper" >
                        <x-response />
                        @yield('content')
                    </div>
                </div>
                <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



 <!-- BEGIN: Vendor JS-->
 <!-- BEGIN Vendor JS-->
 <!-- BEGIN: Page Vendor JS-->
 <script src="/back/app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script src="/back/app-assets/vendors/js/extensions/unslider-min.js"></script>
 <script src="{{asset('back')}}/app-assets/vendors/js/vendors.min.js"></script>

 <script src="{{asset('back')}}/app-assets/vendors/js/charts/apexcharts/apexcharts.min.js"></script>
 <!-- END: Page Vendor JS-->
 @yield('jsler')
 <!-- BEGIN: Theme JS-->
 <script src="{{asset('back')}}/app-assets/js/core/app-menu.js"></script>
 <script src="{{asset('back')}}/app-assets/js/core/app.js"></script>
 <!-- END: Theme JS-->
 <!-- BEGIN: Page JS-->
 <script src="{{asset('back')}}/app-assets/js/scripts/cards/card-statistics.js"></script>
 <script src="{{asset('back')}}/assets/js/include.js"></script>
 <!-- BEGIN: Page Vendor JS-->

  <!-- END: Page Vendor JS-->

 <!-- END: Page Vendor JS-->

 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
 <script src="{{asset('back')}}/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
 <script src="{{asset('back')}}/app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
 <script src="{{asset('back')}}/app-assets/js/scripts/forms/switch.js"></script>
 <script src="{{asset('back')}}/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script> 
 <script src="{{asset('back')}}/app-assets/vendors/js/extensions/toastr.min.js"></script>
 <script src="{{asset('back')}}/app-assets/js/scripts/extensions/toastr.js"></script>
    {{-- Page js     --}}

 @yield('page.js')



 

 <!-- END: Page JS-->
</body>
<!-- END: Body-->
</html>
    