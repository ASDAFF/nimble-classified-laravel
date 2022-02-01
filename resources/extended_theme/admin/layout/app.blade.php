<?php
$setting = DB::table('setting')->first();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/ico/'.@$setting->favicon) }}">
    <!-- App title -->
    <title> {{ $setting->title }} | Admin panel</title>

    <!-- App css -->
    <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert -->
    <link href="{{ asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin_assets/css/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script>
        window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token(), ]) !!};
        var base_url = '<?= url('/') ?>';
    </script>
    <style>
        .goog-te-banner-frame, .goog-te-gadget-icon{
            display: none !important;
        }
        .goog-te-menu-value,.goog-te-menu-value span {color: white!important;}
        .goog-te-gadget-simple{border: 0!important; padding-top: 7px !important; background-color: transparent !important;}
        .goog-te-menu-value:hover{ text-decoration: none!important; }
        body{
            top: 0!important;
        }
    </style>
</head>
<body>

<!-- Loader -->
{{--<div id="preloader">
    <div id="status">
        <div class="spinner">
            <div class="spinner-wrapper">
                <div class="rotator">
                    <div class="inner-spin"></div>
                    <div class="inner-spin"></div>
                </div>
            </div>
        </div>
    </div>
</div>--}}
<!-- LOADING  -->
<div style=" top: 0px; bottom: 0px; left: 0px; position: fixed; width: 100%; z-index: 999999; display: none; background: rgba(0,0,0,0.5);" id="loading">
    <div style="margin: 20% 45%; text-align: center;">
        <img src="{!! asset('assets/images/loader1.gif') !!}" alt=""  class="loading"><br />
        <span style="color: mintcream;"> Processing...</span>
    </div>
</div>
NIMBLEADS
<input type="hidden" id="delete_link" value="<?php echo route('delete'); ?>" >
<!-- HOME -->
<div id="wrapper">

    @if(!Auth::guest())
    @include('admin.layout.nav')
    @endif
            <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    @yield('content')
    
</div>
<!-- END HOME -->

@include('admin.layout.footer')
