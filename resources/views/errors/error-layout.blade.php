<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Page Title -->
    <title>@yield('title')</title>

    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/public/backend/assets/img/favicon.png') }}">

    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">

    <!-- ======= BEGIN GLOBAL MANDATORY STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/fonts/icofont/icofont.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/public/backend/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }}">
    <!-- ======= END BEGIN GLOBAL MANDATORY STYLES ======= -->

    <!-- ======= MAIN STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/css/style.css') }}">
    <!-- ======= END MAIN STYLES ======= -->
    <style>
        body {
            font-size: 15px;
            line-height: 1.466;
            color: #727272;
            background-color: #f0f0f0;
            -webkit-font-smoothing: antialiased;
            font-family: "PT Sans", "Arial", "Roboto", sans-serif;
        }

        .mx-1350 {
            max-width: 1350px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="mn-vh-100 d-flex align-items-center mx-1350 mt-4">
        <div class="container-fluid">
            <div class="card justify-content-center py-5 px-4">
                <div class="row justify-content-center my-5 pt-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
    <script src="{{ asset('/public/backend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/public/backend/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/public/backend/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/public/backend/assets/js/script.js') }}"></script>
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
</body>

</html>
