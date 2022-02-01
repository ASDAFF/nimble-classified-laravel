<?php
$setting = DB::table('setting')->first();
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if( isset($setting->title)) {{ $setting->title }} @endif </title>
    <link rel="shortcut icon" href="{{ asset('assets/ico/'.@$setting->favicon) }}">
    <!-- CSS -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <!-- Sweet Alert -->
    <link href="{{ asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Notification css (Toastr) -->
    <link href="{{ asset('admin_assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/js/extended_js/jquery.min.js') }}"></script>
    <link href="{{ asset('assets/css/icofont.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/owl.carousel.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/slidr.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/main.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <link id="preset" rel="stylesheet" href="{{ asset('assets/css/presets/preset'.$setting->theme_css.'.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
    <!-- font -->
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500,700,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet' type='text/css'>
    <!-- icons -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        /* ajax post setup for csrf token */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var base_url = '<?= url('/') ?>';
    </script>
    <style>
        .navbar-brand>img {
            height: 54px;
            margin-top: -14px;
        }
        .goog-te-gadget-icon{display: none}
        #header .navbar-default{
            border-radius: 0!important;
        }
         #footer, .footer-top{ background-color: {{ (isset($setting->footer_bg))? $setting->footer_bg : '' }}!important; }
        #main{ background-color: {{ isset($setting->body_bg)? $setting->body_bg : '' }}!important; }
        .footer-title{ color: {{ isset($setting->footer_head_color)? $setting->footer_head_color : '' }}!important; }
        .footer-col li a, .copy-info{ color: {{ isset($setting->footer_link_color)? $setting->footer_link_color : '' }}!important; }

        @if(isset($setting->nav_bg))
        #header .navbar-default{
            background-color: {{ $setting->nav_bg }} !important;
        }
        @endif
        .goog-te-banner-frame, .goog-te-gadget-icon{
            display: none !important;
        }
        .goog-te-gadget-simple{border: 0!important; padding-top: 7px !important; background-color: transparent !important;}
        .goog-te-menu-value:hover{ text-decoration: none!important; }
       @if(!Auth::guest())
        @media (max-width: 767px){
            #header a.btn {               
                top: 128px;               
            }
        }
        @endif
    </style>
    {!! @$setting->header_script !!}

</head>
<body>
<input type="hidden" id="delete_link" value="{{url('/')}}/delete" >
<!-- header -->
<header id="header" class="clearfix">
    <!-- navbar -->
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- navbar-header -->
            <div class="navbar-header">

                <a href="{{url('/')}}" class="navbar-brand">
                    @if(isset($setting->logo)) <img src="{{ asset('assets/images/logo/'.$setting->logo)}}" alt="logo" class="img-responsive"> @endif
                </a>

            </div>
            <!-- /navbar-header -->

            <!-- nav-right -->
            <div class="nav-right">
                <!-- language-dropdown -->
                @if(!Auth::guest())
                <div class="dropdown language-dropdown">
                    <ul class="sign-in">
                    @if($setting->translate == 1)
                        <li id="google_translate_element"></li>
                    @endif

                    @if($setting->map_listings == 1)
                        <li><a href="{{ route('map-listings') }}">Map Listings <i class="fa fa-map-marker"></i></a></li>
                    @endif
                    </ul>

                    <i class="fa fa-user"></i>
                    <a data-toggle="dropdown" href="#"><span class="change-text">{{ ucfirst( Auth::user()->name ) }}</span> <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu language-change">
                        @if(Auth::user()->type == 'adm')
                            <li><a href="{{ url('dashboard') }}"><i class="fa fa-bar-chart"></i> Admin Dashboard </a></li>
                        @endif
                        <li><a href="{{ url('user-panel') }}"><i class="fa fa-home"></i> Dashboard </a></li>

                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Log out </a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                    <?php $temp = DB::table('message')->where(['to' => Auth::user()->id, 'is_checked' => 0])->count();?>

                </div><!-- language-dropdown -->
                    <a href="{{route('message.index')}}"><i class="fa fa-envelope f-20"></i> <small class="badge badge-white chat_notify"> {{ $temp }} </small>  </a>
            @endif
                <!-- sign-in -->
                <ul class="sign-in">
                    @if(Auth::guest())
                        @if($setting->translate == 1)
                            <li id="google_translate_element"></li>
                        @endif
                        @if($setting->map_listings == 1)
                            <li><a href="{{ route('map-listings') }}"><i class="fa fa-map-marker"></i> Map Listings &nbsp;&nbsp;</a></li>
                        @endif
                        <li><a href="{{route('login')}}"><i class="fa fa-user"></i> Sign In </a></li>
                        <li><a href="{{route('register')}}"><i class="fa fa-sign-in"></i> Register</a></li>
                    @endif
                </ul><!-- sign-in -->
                <a href="{{route('ads.create')}}" class="btn">Post Your Ad</a>
            </div>
            <!-- nav-right -->
        </div><!-- container -->
    </nav><!-- navbar -->
</header><!-- header -->

@yield('content')
@include('partials.footer')