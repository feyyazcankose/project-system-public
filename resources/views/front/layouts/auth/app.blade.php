<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="fonts/icomoon/style.css">


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('front/auth')}}/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/bootstrap.css">

  <link rel="stylesheet" type="text/css" href="{{asset('back')}}/app-assets/css/bootstrap-extended.css">

  <!-- Style -->
  <link rel="stylesheet" href="{{asset('front/auth')}}/css/style.css">

  <title>@yield('title','Giriş Yap')</title>
</head>

<body>


  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('{{asset('front/auth')}}/images/kou-logo.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        @yield('content')
      </div>
    </div>


  </div>




</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="{{asset('back')}}/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
<script src="{{asset('back')}}/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>

</html>