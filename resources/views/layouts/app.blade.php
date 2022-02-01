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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('assets/ico/fav.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('assets/ico/fav.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('assets/ico/fav.ico')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/ico/fav.ico')}}">
    <link rel="shortcut icon" href="{{asset('assets/ico/'.@$setting->favicon)}}">

    <link href="{{ asset('assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/compo.css') }}" rel="stylesheet" type="text/css" />
    <!-- Notification css (Toastr) -->
    <link href="{{ asset('admin_assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script>
        /* ajax post setup for csrf token */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        paceOptions = {
            elements: true
        };
        var base_url = '<?= url('/') ?>';
    </script>
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <style>
        .footer-content{ background-color: {{ (isset($setting->footer_bg))? $setting->footer_bg : '' }}!important; }
        body{top: 0!important; background-color: {{ isset($setting->body_bg)? $setting->body_bg : '' }}!important; }
        .footer-title{ color: {{ isset($setting->footer_head_color)? $setting->footer_head_color : '' }}!important; }
        .footer-col li a, .copy-info{ color: {{ isset($setting->footer_link_color)? $setting->footer_link_color : '' }}!important; }
        .goog-te-banner-frame, .goog-te-gadget-icon{
            display: none !important;
        }
        .goog-te-gadget-simple{border: 0!important; padding-top: 7px !important; background-color: transparent !important;}
    .goog-te-menu-value:hover{ text-decoration: none!important; }
        @if(@$setting->t_bg_img!='')
        .main_bg{ background-image: url({!! asset('assets/images/bg/'.@$setting->t_bg_img) !!})!important;
            background-position: {{ @$setting->t_bg_position }}
        }
        @endif
        @if(@$setting->b_bg_img!='')
        .stat_bg{ background-image: url({!! asset('assets/images/bg/'.@$setting->b_bg_img) !!})!important;
            background-position: {{ @$setting->b_bg_position }} }
        @endif
    </style>
    {!! @$setting->header_script !!}
</head>
<body>

<input type="hidden" id="delete_link" value="<?php echo route('delete'); ?>" >
<div id="wrapper">
    <div class="header">
        <nav class="navbar navbar-site navbar-default" role="navigation" style="background-color: {{ isset($setting->nav_bg)? $setting->nav_bg:'' }} !important;">
            <div class="container">
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle pull-left" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="btn btn-lg pull-right btn-border btn-post btn-danger btn-submit" href="{{route('ads.create')}}">
                        Insert <img src="{{ asset('assets/img/cam.png') }}" alt="camera" height="25px">
                    </a>
                    <button class="flag-menu country-flag btn btn-default hidden" href="#select-country" data-toggle="modal">
                        <span class="flag-icon flag-icon-us"></span> <span class="caret"></span>
                    </button>
                    <a href="{{url('/')}}" class="navbar-brand logo logo-title">
                        @if(isset($setting->logo)) <img src="{{ asset('assets/images/logo/'.$setting->logo)}}" alt="logo" class="img-responsive"> @endif
                    </a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        @if($setting->translate == 1)
                            <li id="google_translate_element"></li>
                        @endif

                        @if($setting->map_listings == 1)
                            <li><a href="{{ route('map-listings') }}">Map Listings <i class="fa fa-map-marker"></i></a></li>
                        @endif

                        @if(Auth::guest())
                            <li><a href="{{route('login')}}" class="btn btn-link btn-auth font-15"><i class="icon-login"></i> Log In </a></li>
                            <li> &nbsp;</li>
                            <li><a href="{{route('register')}}" class="btn btn-link btn-auth font-15"><i class="icon-user-add"></i> Sign Up </a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span>{{ ucfirst( Auth::user()->name ) }}</span> <i class="icon-user fa"></i> <i class=" icon-down-open-big fa"></i></a>
                            <ul class="dropdown-menu user-menu">
                                @if(Auth::user()->type == 'adm')
                                <li><a href="{{ url('dashboard') }}"><i class="fa fa-bar-chart"></i> Admin Dashboard </a></li>
                                @endif
                                <li><a href="{{ url('user-panel') }}"><i class="icon-home"></i> Dashboard </a></li>

                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class=" icon-logout "></i> Log out </a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>
                        <?php $temp = DB::table('message')->where(['to' => Auth::user()->id, 'is_checked' => 0])->count();?>
                            <li><a href="{{route('message.index')}}"><i class="icon-chat color-white f-20"></i> <small class="badge badge-white chat_notify"> {{ $temp }} </small>  </a></li>
                        @endif
                        <li class="postadd"><a class="btn btn-block   btn-border btn-post btn-danger" href="{{route('ads.create')}}">Post Free Ad
                            <img src="{{ asset('assets/img/cam.png') }}" alt="camera" height="25px"></a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
@yield('content')

@include('partials.footer')
