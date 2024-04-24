<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('headTitle')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/fonts/SansPro/SansPro.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/mycustomstyle.css') }}">
    <!-- mycustomstyle -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/mycustomstyle.css') }}">
    <!-- //css -->
    @yield('css')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/toastr/toastr.min.css') }}">


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.include._navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('admin.include._sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header body_head_style">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@yield('pageTitle')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            @yield('breadcrumb')
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                by Ammar Ibrahim
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 </strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ URL::asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <!-- script -->
    @yield('script')
    <!-- Toastr -->
    <script src="{{ URL::asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <!-- general js -->

    @include('admin.partials._session')
    @yield('include')
</body>

</html>
