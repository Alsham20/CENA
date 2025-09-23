<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Backoffice | Panel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Acom panel admin" name="description" />
    <meta content="Acom" name="author" />
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.material.css') }}">

    <!-- App favicon -->

    @yield('style')
    @livewireStyles
    @include('admin.layouts.style')


</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Topbar Start ========== -->
        @include('admin.layouts.navbar')
        <!-- ========== Topbar End ========== -->
        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.layouts.sidebar')
        <!-- ========== Left Sidebar End ========== -->
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            @yield('content')
            <!-- Footer Start -->
            @include('admin.layouts.footer')
            <!-- end Footer -->
        </div>
    </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    <!-- END wrapper -->

    <!-- Theme Settings -->
    @include('admin.layouts.settings')
    @livewireScripts
    @include('admin.layouts.js')
    @yield('js')


</body>
</html>
