<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="{{asset('')}}">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic:400,700,800" rel="stylesheet">
    <link rel="stylesheet" href="frontend/fonts/icomoon/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/css/magnific-popup.css">
    <link rel="stylesheet" href="frontend/css/jquery-ui.css">
    <link rel="stylesheet" href="frontend/css/owl.carousel.min.css">
    <link rel="stylesheet" href="frontend/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="frontend/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="frontend/fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="frontend/css/aos.css">
    <link rel="stylesheet" href="frontend/css/rangeslider.css">

    <link rel="stylesheet" href="frontend/css/style.css">

    @yield('style')

</head>

<body>

    @include('frontend.layouts.components.header')

    <div class="site-wrap">


        @yield('content')

    </div>

</body>
    @include('frontend.layouts.components.footer')

    <script src="frontend/js/jquery-3.3.1.min.js"></script>
    <script src="frontend/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="frontend/js/jquery-ui.js"></script>
    <script src="frontend/js/popper.min.js"></script>
    <script src="frontend/js/bootstrap.min.js"></script>
    <script src="frontend/js/owl.carousel.min.js"></script>
    <script src="frontend/js/jquery.stellar.min.js"></script>
    <script src="frontend/js/jquery.countdown.min.js"></script>
    <script src="frontend/js/jquery.magnific-popup.min.js"></script>
    <script src="frontend/js/bootstrap-datepicker.min.js"></script>
    <script src="frontend/js/aos.js"></script>
    <script src="frontend/js/rangeslider.min.js"></script>

    <script src="frontend/js/main.js"></script>
    @yield('script')

</html>
