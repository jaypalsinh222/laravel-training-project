<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <link rel="stylesheet" href={{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}> --}}
    <!-- iCheck -->
    {{-- <link rel="stylesheet" href={{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}> --}}
    <!-- JQVMap -->
    {{-- <link rel="stylesheet" href={{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset('assets/dist/css/adminlte.min.css') }}>
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href={{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}>
    <!-- Daterange picker -->
    {{-- <link rel="stylesheet" href={{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}> --}}
    <!-- summernote -->
    {{-- <link rel="stylesheet" href={{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}> --}}

    <!-- Toastr Message Display -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    {{-- datatables --}}
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    {{--    ----------------------------------}}


    <!-- Font Awesome -->

    <!-- icheck bootstrap -->

    <!-- Theme style -->


    <!-- Adding Css -->
    @stack('css_push')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

<!-- Preloader -->


<!-- Header -->


<!-- left sidebar -->

<!-- Main Cintent -->
{{-- @yield('main-content') --}}
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                @include('user.header')
                @yield('main-content')
            </div>
        </div>
    </div>
</section>
<!-- Footer -->
{{-- @include('layouts.footer') --}}


<!-- jQuery -->

<script src={{ asset('assets/plugins/jquery/jquery.min.js') }}></script>
<!-- jQuery UI 1.11.4 -->
{{-- <script src={{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}></script> --}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    // $.widget.bridge('uibutton', $.ui.button)
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
<!-- Bootstrap 4 -->
<script src={{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}></script>
<!-- ChartJS -->
{{-- <script src={{ asset('assets/plugins/chart.js/Chart.min.js') }}></script> --}}
<!-- Sparkline -->
{{-- <script src={{ asset('assets/plugins/sparklines/sparkline.js') }}></script> --}}
<!-- JQVMap -->
{{-- <script src={{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}></script>
<script src={{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}></script> --}}
<!-- jQuery Knob Chart -->
{{-- <script src={{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}></script> --}}
<!-- daterangepicker -->
{{-- <script src={{ asset('assets/plugins/moment/moment.min.js') }}></script> --}}
{{-- <script src={{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}></script> --}}
<!-- Tempusdominus Bootstrap 4 -->
{{-- <script src={{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}></script> --}}
<!-- Summernote -->
{{-- <script src={{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}></script> --}}
<!-- overlayScrollbars -->
<script src={{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}></script>
<!-- AdminLTE App -->
<script src={{ asset('assets/dist/js/adminlte.js') }}></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src={{ asset('assets/dist/js/demo.js') }}></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src={{ asset('assets/dist/js/pages/dashboard.js') }}></script> --}}
<!-- Toastr Message -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@if (session()->has('success'))
    <script type="">
        toastr.success("{!! Session::get('success') !!}");
    </script>
@endif
@if (session()->has('fail'))
    <script type="">
        toastr.error("{!! Session::get('fail') !!}");
    </script>
@endif
<!-- Adding Script -->
@stack('script_push')


</body>

</html>
