<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Nguyen Khai">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>@yield('title')</title>

    <!-- Fontfaces CSS-->
    <base href="{{asset('')}}">
    <link href="backend/assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap CSS-->
    <link href="backend/assets/vendors/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- vendors CSS-->
    <link href="backend/assets/vendors/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet"
        media="all">
    <link href="backend/assets/vendors/wow/animate.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/slick/slick.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="backend/assets/css/theme.css" rel="stylesheet" media="all">
    @yield('style')

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        @include('backend.layouts.components.header_mobile')
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        @include('backend.layouts.components.sidebar')
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->

            @include('backend.layouts.components.header')
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            @yield('main')

        </div>
    </div>

    <!-- Jquery JS-->
    <script src="backend/assets/vendors/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="backend/assets/vendors/bootstrap-4.1/popper.min.js"></script>
    <script src="backend/assets/vendors/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- vendors JS       -->
    <script src="backend/assets/vendors/slick/slick.min.js">
    </script>
    <script src="backend/assets/vendors/wow/wow.min.js"></script>
    <script src="backend/assets/vendors/animsition/animsition.min.js"></script>
    <script src="backend/assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="backend/assets/vendors/counter-up/jquery.waypoints.min.js"></script>
    <script src="backend/assets/vendors/counter-up/jquery.counterup.min.js">
    </script>
    <script src="backend/assets/vendors/circle-progress/circle-progress.min.js"></script>
    <script src="backend/assets/vendors/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="backend/assets/vendors/chartjs/Chart.bundle.min.js"></script>
    <script src="backend/assets/vendors/select2/select2.min.js"></script>
    <!-- Main JS-->
    <script src="backend/assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    @yield('script')

</body>

</html>
<!-- end document-->
