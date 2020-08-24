<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>HK MARKET - Login</title>

    <!-- Fontfaces CSS-->
    <base href="{{asset('')}}">
    <link href="backend/assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="backend/assets/vendors/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

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
    <link href="backend/assets/vbackend/assets/endor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet"
        media="all">

    <!-- Main CSS-->
    <link href="backend/assets/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <img width="150" src="backend/assets/images/logo.png" alt="CoolAdmin">
                        </div>
                        <div class="login-form">
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ session('error') }}</strong>
                            </div>
                            @endif
                            <form action="{{route('admin.post.login')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email"
                                        placeholder="Email">
                                    @if($errors->has('email'))
                                    <p class="text-danger">{{$errors->first('email')}}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password"
                                        placeholder="Password">
                                    @if($errors->has('password'))
                                    <p class="text-danger">{{$errors->first('password')}}</p>
                                    @endif
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="backend/assets/vendors/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="backend/assets/js/main.js"></script>

</body>

</html>
<!-- end document-->
