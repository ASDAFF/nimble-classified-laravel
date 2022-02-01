@extends('layouts.app')
@section('content')
    <style>
        .top-80{ top:80px}
        .list-group-item{  padding: 10px 5px}
        .btn-lg { width: 30%}
        .bx-viewport{ height: auto !important}
        .seller-info .thumbnail {height: 76px; width: 75px !important}
        .company-logo-thumb{float: left}

         h3.pull-left.title {
            font-size: 36px;
            font-weight: 400;
            color: #000;
            margin: 11px 0 8px;
        }
        #rating{
            margin-bottom: 5px;
        }
        #rating .fa{
            font-size: 22px!important;
        }
        .media-heading{ padding-left: 5px; font-size: 12px!important; }
        aside.panel.panel-body.panel-details{ padding:5px!important;}
        .key-features .media i {  font-size: 20px;   margin-right: 3px; }
        .text-center{ text-align: center!important; }
        .p-25{padding: 5px 15px 5px 15px;}
        .seller-info img{
            height:100px;
        }
        .col-md-5.bx-shadow{
            box-shadow: 2px 3px 17px -2px;
            padding-bottom: 20px;
        }

    </style>
<?php
$setting = DB::table('setting')->first();
$avator = asset('assets/images/users/male.png');
if(!isset($data->user->image)){
    if($data->user->type == 'c' ){
        $avator = asset('assets/images/users/company.png');
    }
    if($data->user->type == 'u' || $data->user->type == 'adm' ){
        if($data->user->gender == 'm'){
            $avator = asset('assets/images/users/male.png');
        }
        if($data->user->gender == 'f'){
            $avator = asset('assets/images/users/female.png');
        }
    }
}else
    if($data->user->image!= ''){
        $avator = asset('assets/images/users/'.$data->user->image.'');
    }

?>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- main -->
    <section id="main" class="clearfix details-page">
        <div class="container">
            @if($setting->single_ads  == 1 && $setting->single_ads_p == 'ah' )
                <div class="ads_bs m-b-10">
                    {!! $setting->single_adsense !!}
                </div>
            @endif

            <div class="section slider p-b-100">
                <div class="row">
                    <!-- carousel -->
                    <div class="col-md-7 slider-text">
                        <h3 class="pull-left title">{{ ucfirst($data->title) }}</h3>
                        <h2 class="pull-right">{{ $setting->currency_place == 'left' ? $setting->currency : ''  }}{{ number_format($data->price) }} {{  $setting->currency_place == 'right' ? $setting->currency : ''  }}  {{ ($data->price_option!='')? '/'.$data->price_option : '' }}</h2>

                        <div class="clearfix"></div>

                        <span class="icon"><i class="fa fa-clock-o"></i><a href="javascript:void(0)" data-toggle="tooltip" data-title="Posted date">{{ $data->created_at->diffForHumans() }}</a></span>
                        <span class="icon"><i class="fa fa-map-marker"></i><a href="javascript:void(0)" data-toggle="tooltip" data-title="city name">{{ ucfirst($data->city->title) }} </a></span>
                        <span class="icon"><i class="fa fa-list"></i><a data-toggle="tooltip" data-title="category" href="{{url('search/query?main_category='.$data->category->slug)}}">{{ ucfirst($data->category->name) }} </a></span>
                        <span class="icon"><i class="fa fa-line-chart"></i><a href="javascript:void(0)" data-toggle="tooltip" data-title="ad views">{{ floor($data->visit/2) }}</a></span>
                        <hr>
                        <div id="product-carousel" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                @if(count($data->ad_images) > 0)
                                <?php $count=0; ?>
                                    @foreach($data->ad_images as $img)
                                        <li data-target="#product-carousel" data-slide-to="{{$count}}" class="@if($count == 0) active @endif ">
                                            <img class="img-responsive" src="{{ asset('assets/images/listings/'.$img->image.'') }}" alt="img">
                                        </li>
                                       <?php $count++; ?>
                                    @endforeach
                                @else
                                    <li style="float: left; list-style: none; position: relative; width: 497px;" class="img-responsive"><img src="{{ asset('assets/images/listings/empty.jpg') }}" alt="img"></li>
                                @endif
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <!-- item -->
                                @if(count($data->ad_images) > 0)
                                    <?php $count=0; ?>
                                    @foreach($data->ad_images as $img)
                                <div class="item @if($count == 0) active @endif">
                                    <div class="carousel-image">
                                        <!-- image-wrapper -->
                                        <img src="{{ asset('assets/images/listings/'.$img->image.'') }}" alt="Featured Image" class="img-responsive">
                                    </div>
                                </div><!-- item -->
                                    <?php $count++; ?>
                                    @endforeach
                                @else
                                    <div class="item @if($count == 0) active @endif">
                                        <div class="carousel-image">
                                            <!-- image-wrapper -->
                                            <img src="{{ asset('assets/images/listings/empty.jpg') }}" alt="Featured Image" class="img-responsive">
                                        </div>
                                    </div><!-- item -->
                                @endif
                            </div><!-- carousel-inner -->
                        @if(count($data->ad_images) > 0)
                            <!-- Controls -->
                            <a class="left carousel-control" href="#product-carousel" role="button" data-slide="prev">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <a class="right carousel-control" href="#product-carousel" role="button" data-slide="next">
                                <i class="fa fa-chevron-right"></i>
                            </a><!-- Controls -->
                            @endif
                        </div>
                        <div style="margin-bottom: 35px"></div>
                    </div><!-- Controls -->
                    <!-- slider-text -->
                    <div class="col-md-5 bx-shadow">
                        <h6 class="pull-right"><a href="javascript:;" onclick="goBack()"> <i class="fa fa-angle-double-left"></i>  Back to Results</a></h6>

                        <div class="short-info">
                            <h4>{{ ( $data->user->type == 'c' )? 'Contact Dealer' : 'Contact Person' }}</h4>
                            <div class="seller-info" style="position: relative">
                                <div class="company-logo-thumb col-md-4 row">
                                    <img src="{{ $avator }}" class="thumbnail" alt="img">
                                </div>
                                <div class="company-logo-thumb col-md-8 row">
                                    <div class="m-l-5">
                                        <h4 class="no-margin"> {{ ucwords($data->user->name) }}   <i> {!!  ($data->user->is_login == 1)? '<span data-toggle="tooltip" data-title="Online" class="fa online"></span>' : '<span data-toggle="tooltip" data-title="Offline" class="fa offline"></span>' !!} </i></h4>
                                        @if($data->user->is_verified == 2)
                                            <a class="label label-primary text-white"> Verified User </a>
                                        @endif
                                        @if($data->user->mobile_verify == 1)
                                            <a class="label label-primary m-l-5 text-white m-t-5">Phone Verified</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="text-leftt clearfix">

                                    @if($data->user->type == 'c')
                                        @if($data->user->telephone)
                                            <p>Telephone: <strong>{{ ucfirst($data->user->telephone) }}</strong></p>
                                        @endif
                                        @if($data->user->fax)
                                            <p>FAx: <strong>{{ ucfirst($data->user->fax) }}</strong></p>
                                        @endif
                                        @if($data->user->address)
                                            <p>Location: <strong>{{ ucfirst($data->user->address) }}</strong></p>
                                        @endif
                                    @endif

                                    <?php

                                    $user_rated = '';
                                    $rating = DB::table('user_rating')
                                        ->select(DB::raw('count(score) as total, AVG(score) as avg'))
                                        ->where('user_id', $data->user->id)->first();

                                    if(!Auth::guest()){
                                        /* check ip recorded rating ? */
                                        $user_rated = DB::table('user_rating')
                                            ->where(['user_id' => $data->user->id, 'by_user' => auth::user()->id])
                                            ->value('id');
                                    }
                                    ?>
                                    @if(!Auth::guest() && auth::user()->id != $data->user->id)
                                        <div data-toggle="tooltip" id="rating" {{ $user_rated!='' ? 'data-read="true"' : '' }} data-score="{{ floor($rating->avg) }}" class="click" ></div>
                                    @else
                                        <div id="rating" data-read="true" data-score="{{ floor($rating->avg) }}" class="click" ></div>
                                    @endif

                                </div>
                                <a href="{{ url('user-ads', $data->user->id) }}" class="btn btn-primary btn-block m-t-5"> <i class=" fa fa-user"></i> More ads by User </a>
                            </div>
                        </div>
                        <div class="slider-text">
                            <!-- contact-with -->
                            <div class="contact-with">
                                <h4>Contact with </h4>
                                <span class="btn btn-red show-number">
									<i class="fa fa-phone-square"></i>
									<span class="hide-text">Click to show phone number </span>
									<span class="hide-number">{{ $data->user->phone}}</span>
								</span>
                                @if( $data->user->id != Auth::user()->id)
                                    <a href="javascript:;" class="btn" data-toggle="modal" data-target="#contactModalId"><i class="fa fa-envelope-square"></i>Reply by email</a>
                                @endif
                            @if(!Auth::guest() && Auth::user()->chat_lock == 0)
                                <!-- check if user is locked or not in chat setting table -->
                                <?php
                                $is_locked = DB::table('chat_setting')->where([ 'user_id' => Auth::user()->id, 'blocked_user' => $data->user->id ] )->value('blocked_user');

                                ?>
                                @if( $data->user->id != Auth::user()->id && $data->user->is_login == 1 && $is_locked =='' )
                                    <button  class="btn btn-default btn-lg chathead" data-for="{{ $data->user->id }}"><i class=" icon-chat"></i> Chat Now </button>
                                @endif
                            @endif
                            </div><!-- contact-with -->

                            <!-- social-links -->
                            <div class="social-links">
                                <h4>Share this ad</h4>
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style m-b-5 m-t-20" style="margin-top: -18px;">
                                    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                    <a class="a2a_button_sms"></a>
                                    <a class="a2a_button_facebook"></a>
                                    <a class="a2a_button_twitter"></a>
                                    <a class="a2a_button_whatsapp"></a>
                                    <a class="a2a_button_copy_link"></a>
                                    <a class="a2a_button_facebook_messenger"></a>
                                    <a class="a2a_button_google_plus"></a>
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                            </div><!-- social-links -->
                        </div>

                    </div><!-- slider-text -->
                    <br>
                    <br>
                    @if( $setting->single_ads == 1 && $setting->single_ads_p == 'r' )
                        <div class=" inner-box">
                            <!-- ads box -->
                            {!! $setting->single_adsense !!}
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div><!-- slider -->

            <div class="description-info">
                <div class="row">
                    <!-- description -->
                    <div class="col-md-8">
                        <div class="description">
                            <h4>Description</h4>
                            {!! $data->description !!}
                            <hr>
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s); js.id = id;
                                    js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2';
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));
                            </script>
                            <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                        </div>
                    </div><!-- description -->
                    <!-- description-short-info -->
                    <div class="col-md-4">
                        @if(count($ad_cf_data) > 0 )
                            <div class="short-info">
                                <h4>Short Info</h4>
                                <ul>
                                    @foreach($ad_cf_data as $index => $value)
                                        <?php $type = $value->type ?>
                                        @if($value->column_value !='' && $value->img =='' && $value->type !='textarea')
                                            @if($value->icon !='' || $value->image!='')
                                                <li> <strong> {!! ($value->icon!='')? '<i class="'.$value->icon.'"></i>' : '<img src="'.asset('assets/images/c_icons/'.$value->image.'').'" height="20" width="20">' !!}</strong> </li>
                                            @endif
                                            <li><strong>{{ ucfirst( str_replace('_', ' ', $value->column_name) ) }} </strong>
                                                @if( $type == 'url')
                                                    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="pull-right" target="_blank" href="{{ $value->column_value  }}"> {{  parse_url($value->column_value, PHP_URL_HOST)  }}</a></strong>
                                                @elseif( $type =='checkbox' || $type == 'radio')
                                                    {{ (ucfirst($value->column_value) == 1)? 'Yes': ucfirst($value->column_value) }} {{ $value->inscription }}
                                                @else
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    {{ ucfirst($value->column_value) }} {{ $value->inscription }}
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div><!-- row -->
            </div><!-- description-info -->
        </div><!-- container -->
    </section><!-- main -->

<!-- Modal contact user-->
<div class="modal fade top-80" id="contactModalId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="loginModelTitleId"> {{ (!Auth::guest())? 'Contact User' : 'Login to send message' }} </h4>
            </div>
            <div class="modal-body">
                <div id="login-container" class="{{ (!Auth::guest())? 'hidden' : '' }}">
                    <form id="loginform">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="email" class=" control-label">E-Mail Address:</label>
                                <div class="input-icon"><i class="icon-user fa"></i>
                                    <input id="email" type="email" class="form-control" name="email"  required autofocus autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="password" class="control-label">Password:</label>
                                <div class="input-icon"><i class="icon-lock fa"></i>
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" > Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div id="Email-container" class="{{ (Auth::guest())? 'hidden' : '' }}">
                <div id="Email-container" class="{{ (Auth::guest())? 'hidden' : '' }}">
                    <form id="contactForm" action="">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $data->user->id }}">
                        <input type="hidden" name="ad_id" value="{{ $data->id }}">
                        <div class="form-group">
                            <label for="">Message <span class="text-danger">*</span></label>
                            <textarea required class="form-control" name="msg" id="" rows="3" placeholder="Add text here.."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"> <i class="icon-mail" aria-hidden="true"></i> Send </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                @if(Auth::guest())
                    <a href="{{ route('register') }}" class="btn btn-primary reg_btn">Register</a>
                @endif
                <a href="javascript:void(0)" type="button" class="btn btn-info" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal show phone number -->
    <div class="modal fade top-80" id="showPhone" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title text-center">  Do business in safety on {{ $setting->title }}</h3>
                </div>
                <div class="modal-body text-center">
                    <div class="p-25">
                        <p>
                            If possible meet the seller in person to close the deal. Try to avoid untraceable payment tools.
                        </p>
                        <h3><i class="fa fa-phone" aria-hidden="true"></i> @if($data->user->phone == '') <span class="text-danger">Not available!</span>
                            @else
                                {{ $data->user->phone }}
                                @if($data->user->mobile_verify == 1)
                                    <div class="btn btn-xs btn-success ">Phone Verified</div>
                                @endif
                            @endif
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detail" class="hidden">
        {{ strip_tags(trim(rtrim($data->description))) }}
    </div>

<script src="{{asset('assets/plugins/bxslider/jquery.bxslider.min.js')}}"></script>
<script src="{{asset('assets/js/cookie.js')}}"></script>
    <!-- Rating js -->
    <script src="{{asset('admin_assets/plugins/raty-fa/jquery.raty-fa.js')}}"></script>
<script>
    // detect mobile user
    var is_mobile = !!navigator.userAgent.match(/iphone|android|blackberry/ig) || false;
    $(document).ready(function () {

        var detail = $('#detail').html();

        $('head').append('<meta property="og:url"   content="{{url()->full()}}" />' +
            '  <meta property="og:type"          content="website" />' +
            '  <meta property="og:title"         content="{{ ucfirst($data->title) }}" />' +
            '  <meta property="og:description"   content="'+detail+'" />' +
            '  <meta property="og:image"         content="@if(isset($data->ad_images[0]->orignal_filename)){{ asset('assets/images/listings/'.$data->ad_images[0]->image) }}@endif" /><!-- Twitter Card data -->\n' +
            '<meta name="twitter:card" content="'+detail+'">\n' +
            '<meta name="twitter:site" content="@<?php echo url('/') ?>">\n' +
            '<meta name="twitter:title" content="{{ ucfirst($data->title) }}">\n' +
            '<-- Twitter Summary card images must be at least 120x120px -->\n' +
            '<meta name="twitter:image" content="@if(isset($data->ad_images[0]->orignal_filename)){{ asset('assets/images/listings/'.$data->ad_images[0]->image) }}@endif">');

        if(is_mobile) {
            $('#Mobile_Contact').attr('data-toggle', '').attr('data-target', '');
            $('#Mobile_Contact').attr('href','tel:'+ $('#phone_show').html());
                $('#phone_hide,#phone_show').text('Call');
                $('.chathead').html('<i class=" icon-chat"></i> Chat');
        }
        // ajax submit form
        $("#loginform").submit(function(){
            $('#loading').show();
            var data = new FormData(this);
            $.ajax({
                url: "{{url('user-login')}}",
                data: data,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(result){
                    if(result!=''){
                        //var obj = $.parseJSON(result);
                        var obj = result;
                        if(obj.msg == 1) {
                            swal('Success', 'Login successfully!', 'success');
                            $('#loginModelTitleId').html('Contact User');
                            $('#login-container, .reg_btn').addClass('hidden');
                            $('#Email-container').removeClass('hidden');
                        }else{
                            swal('Error!', 'Wrong password provided!', 'error');
                        }
                        $('#loading').hide();
                    }
                }
            });
            return false;
        });

        // contact Form
        $("#contactForm").submit(function(){
            $("#contactForm button").html( '<i class="fa fa-spinner fa-spin"></i> processing..' );

            var data = new FormData(this);
            $.ajax({
                url: "{{url('contact-user')}}",

                data: data,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(result){
                    if(result!=''){

                        if(result == 1) {
                            $('#contactModalId').modal('hide');
                            swal('Success', 'Message send successfully!', 'success');
                            window.location.reload();
                        }else{
                            swal('Error!', 'Unknown error!', 'error');
                        }
                        $("#contactForm button").html( 'Send' );
                        $("#contactForm textarea").html( '' );
                    }
                }
            });
            return false;
        });
    });
    // start chat function

    $('.chathead').on('click', function () {

        var forchat = $(this).data('for');
        $('#target').val(forchat);

         $.cookie("chatHead", '{{ $data->user->id }}', { path: '/' });
         $.cookie("chatUser", '{{ ucwords($data->user->name) }}', { path: '/' });

        var to = $.cookie('chatHead');

        if(hide_chat != 'hide') {
            $.post(
                    '{{route('load_chat_head')}}',
                    {id: to},
                    function (data) {
                        console.log(data.length);
                        if (data != 0) {
                            //$('#chat .chat').html(data);
                            // scroll down
                            $("#chat .panel-body").scrollTop($("#chat .panel-body")[0].scrollHeight);
                            $('.badge-white').html('0');
                        } else {

                        }
                    }
            );
            $('#chat .input-group').removeClass('hidden');
        }

        if($('#chat .panel-body').hasClass('hidden')){
            if(hide_chat != 'hide') {
                $('#chat .chat').find('center').html('<center> There are not any chats yet! <br> Start chat with <strong>' + $.cookie('chatUser') + '</strong> </center>');
            }
            $('#chat .panel-body,#chat .panel-footer, #chat .btn-settings ').removeClass('hidden');
            $('#chat .btn-indicator').html('<i class="fa fa-angle-up"></i>');
            $("#chat .panel-body").scrollTop($("#chat .panel-body")[0].scrollHeight);
        }else{
            $('#chat .panel-body,.panel-footer').addClass('hidden');
            $('#chat .btn-indicator').html('<i class="fa fa-angle-down"></i>');
        }
    });
    // end chat function

        $('.bxslider').bxSlider({
            pagerCustom: '#bx-pager',
            adaptiveHeight: true
        });

        function show_hide(e){
            var id = $(e).attr('id');
            var str = $(e).data('str');
            var iff = $(e).attr('data-if');

            if(iff == 0){
                $(e).html('<a href="javascript:void(0)"> Hide ' + str + '</a>' );
                $(e).attr('data-if', "1");
            }else {
                $(e).attr('data-if', '0');
                $(e).html( '<a href="javascript:void(0)"> Show all ' + str + '</a>' );
            }
            $('.'+id).toggleClass('hidden', 'slow');

        }

    /* ratery  */

    var hint = '{{$rating->total}} votes, average {{ floor($rating->avg) }} out of 5';

    (function ($) {
        $(function () {
            $('#readOnly').raty({
                readOnly: true,
                score: 3,
            });

            $('.click').raty({
                readOnly: function(){
                    return $(this).attr('data-read');
                },
                score: function () {
                    return $(this).attr('data-score');
                },
                click: function (score, evt)
                {
                    $.post('{{ route('user-rating') }}',
                        {user_id:'{{ $data->user->id }}', score:score, ip:'{{ $user_ip }}'},
                            function(data){
                                if(data.msg == 1){
                                    $("#rating").html('<span class="text-success">Rated '+score+' successfully!</span>');
                                }
                            });
                },
                half: true,
                hints: [hint, hint, hint, hint, hint]
            });
        });
    })(jQuery);
</script>
</div>
@endsection
