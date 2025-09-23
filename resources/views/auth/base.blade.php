<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <title>Connexion | Panel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Acom panel admin" name="description" />
    <meta content="Acom" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- Theme Config Js -->
    <script src="{{asset('assets/js/hyper-config.js')}}"></script>

    <!-- App css -->
    <link href="{{asset('assets/css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    {!! htmlScriptTagJsApi() !!}
</head>

<body class="authentication-bg position-relative">
    <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
        <svg xmlns='http://www.w3.org/2000/svg' width='100%' height='100%' viewBox='0 0 800 800'>
            <g fill-opacity='0.22'>
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.1);" cx='400' cy='400' r='600' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.2);" cx='400' cy='400' r='500' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.3);" cx='400' cy='400' r='300' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.4);" cx='400' cy='400' r='200' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.5);" cx='400' cy='400' r='100' />
            </g>
        </svg>
    </div>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    @yield('form')
                    <!-- end card -->


                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">

    </footer>
    <!-- Vendor js -->
    <script src="{{asset('assets/js/vendor.min.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('assets/js/app.min.js')}}"></script>
    {!! RecaptchaV3::initJs() !!}
</body>


<!-- Mirrored from coderthemes.com/hyper_2/saas/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 May 2024 10:37:24 GMT -->

</html>