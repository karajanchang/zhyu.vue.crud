<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ env('APP_NAME') }} {{ env('ADMIN_NAME', '後台管理') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')  }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/css/adminlte.min.css')}}">
    <!-- buefy--->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


    @livewireStyles

    <link rel="stylesheet" href="{{ asset('/assets/css/app.css')}}">
    <link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet" type="text/css" />

    @stack('css')

    <script type="text/javascript" src="/assets/js/datejs.js"></script>
    <script type="text/javascript">
        window.Laravel = {!! json_encode( ['csrfToken' => csrf_token()] ) !!};
        @if(isset($urls))
            window.urls = {!! json_encode($urls) !!};
        @endif
                @if(isset($tableService))
                {!! $tableService->defaultOrderby() !!};
        @endif
    </script>


    @stack('js')
    <style>
        [data-f-id="pbf"] {
            display: none;
        }
    </style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
@includeFirst(['vendor.blocks.navbar', 'ZhyuVueCurd::blocks/navbar'])
<!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="
                @php
            try{
                route(env('ADMIN_LOGO_IMAGE_ROUTE', 'home'));
            }catch(\Exception $e){
                route('index');
            }
        @endphp
                " class="brand-link">
            {{--            <img src="{{ asset('vendor/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"--}}
            {{--                 style="opacity: .8">--}}
            <div style="display: inline-block;">
                <img src="{{ env('ADMIN_LOGO_IMAGE', '/images/logo.svg') }}" alt="{{ env('ADMIN_LOGO_IMAGE_ALT', 'LOGO') }}" width="{{ env('ADMIN_LOGO_IMAGE_WIDTH', 50) }}" >
            </div>
            <span class="brand-text font-weight-light">{{ env('APP_NAME', 'System') }}</span>
        </a>

        <!-- Sidebar -->
        <livewire:admin.left-menu />
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@if(isset($tableService)) {{ $tableService->title() }} @else @if(isset($title)) {{ $title }}@endif @endif </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url(route('admin.index')) }}">Home</a></li>
                            <li class="breadcrumb-item active">管理</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">

            <div class="container-fluid">
                @yield("content")
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2019 <a href="{{ env('ADMIN_COPYRIGHT_URL', '/') }}">{{ env('ADMIN_COPYRIGHT_COMPANY', 'ZHYU Tech.,') }}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> {{ env('ADMIN_VERSION') }}
            </div>
        </footer>
    </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
<!-- AdminLTE -->
<script src="{{ asset('vendor/js/adminlte.js')}}" type="text/javascript"></script>


@livewireScripts
<script src="https://cdn.jsdelivr.net/gh/livewire/vue@v0.3.x/dist/livewire-vue.js"></script>
<script src="{{ asset('/assets/js/admin.js')}}" type="text/javascript"></script>
@stack('js_append')
</body>
</html>
