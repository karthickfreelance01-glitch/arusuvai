    <!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Arusuvai Mess </title>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400i,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&amp;display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('web/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/assets/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('web/assets/css/slick.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('web/assets/css/main-color04.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>

<body class="biolife-body">

    <!-- Preloader -->
    <!-- <div id="biof-loading">
        <div class="biof-loading-center">
            <div class="biof-loading-center-absolute">
                <div class="dot dot-one"></div>
                <div class="dot dot-two"></div>
                <div class="dot dot-three"></div>
            </div>
        </div>
    </div> -->
      @yield('content')

  <!-- Scroll Top Button -->
    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
    crossorigin="anonymous"></script>
    <script src="{{asset('web/assets/js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('web/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('web/assets/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('web/assets/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('web/assets/js/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('web/assets/js/slick.min.js')}}"></script>
    <script src="{{asset('web/assets/js/biolife.framework.js')}}"></script>
    <script src="{{asset('web/assets/js/functions.js')}}"></script>
</body>

</html>