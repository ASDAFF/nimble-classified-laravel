@extends('layouts.app')
@section('content')
    <?php $setting = \App\Setting::first();   ?>
    <style>
        textarea{  overflow: hidden;  }
        .jFiler-input-dragDrop{
            width: auto !important;
        }
        .wizard > .content > .body{
            padding: 0!important;
        }
        .jFiler-items-grid .jFiler-item .jFiler-item-container{
            margin: 0 8px 30px 0 !important;
        }
        li{
            list-style-type: none !important;
        }
        .content-subheading{
            margin: -10px -28px 20px -25px;
        }
        .wizard > .content > .body label.error{margin-left: 0px !important;}
        .form-group {
            margin-bottom: 0rem;
        }
        .form-horizontal .form-group{
            margin-right: 0px !important;
        }
        .wizard > .actions a{
            border-radius: 0!important;
            width: 140px;
            height: 42px;
            text-align: center!important;
            font-size: 16px;
            padding: 0.6em 1em;
            box-shadow: 0px 6px 40px -18px black;
        }
        .wizard > .steps a{
            border-radius: 0!important;
            box-shadow: 0px 6px 40px -18px black;
        }
        .wizard > .content{
            border-radius: 0!important;
            background-color: white!important;
        @if(isset($ad_data))
            /*min-height:85em!important;*/
        @endif
    }
        .input-icon .form-control{
            padding-left: 35px !important;
        }
        input.form-control{
            padding: 2px 10px !important
        }

        textarea.form-control{
            padding: 5px 5px !important
        }
        .m-r-25{
            margin-right: 25px;
        }
        .top-60{
            top:60px;
        }
        .input-mini{
            padding-left: 25px !important;
        }
        .form-control{
            border: 1px solid #ccc!important;
        }
        #cke_content{
            margin: 1px 25px 0px 13px !important;
        }
        .cke_bottom{
            display: none!important;
        }
        .groups h3{ padding-bottom: 0!important; }
        div.jFiler-items{
            overflow: auto!important;
            height: 320px!important;
        }
        .bootstrap-select li.disabled .text{
            /*color: black !important;*/
        }
        li.dropdown-header .text{

            margin-left: 5px!important;
            font-weight: bold!important;
        }
        .bootstrap-select{
            border: 1px solid #d0d0d0 !important;
        }
        .img-cat{ height:28px; width: 38px; }
        #P_child .col-md-4.col-sm-4.col-xs-4 {
            height: 280px;
            overflow-y: auto;
        }
        #map { height: 270px; }

        #pac-input{
            background-color: #cccccc;
            padding-left: 5px;
        }
        .wizard > .content > .body input[type='radio']{
            display: inline-block!important;
        }
        .vfy_phone_number{
            border: 2px solid #02c102 !important;
        }
    </style>

    <!--Form Wizard-->
    <link type="text/css" href="{{asset('assets/plugins/jquery.steps/css/jquery.steps.css')}}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('assets/css/bootstrap-select.min.css') }}" rel="stylesheet" />

    <!-- Jquery filer css -->
    <link href="{{ asset('assets/plugins/jquery.filer/css/jquery.filer.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet" />

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-9 page-content">
                    <div class="inner-box category-content">
                        <h2 class="title-2 uppercase"><strong> <i class="icon-docs"></i> Post a Free Classified
                                Ad</strong></h2>
                        <!-- Wizard with Validation -->
                        <div class="row">
                            <div class="col-sm-12">
                                {{--<form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!!route('addmoney.stripe')!!}" >--}}
                                {{--{{ csrf_field() }}--}}

                                {{----}}
                                {{--</form>--}}

                                <form id="wizard-validation-form" class="form-horizontal" action="#" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" value="{{ (isset($ad_data))? $ad_data['id'] : '' }}" name="id">
                                    <input type="hidden" value="{{ (isset($ad_data))? $ad_data['user_id'] : '' }}" name="user_id">
                                    <input type="hidden" id="ids" name="image_ids">
                                    <input type="hidden" id="deleted_ids" name="deleted_ids">
                                    <div>
                                        <h3>Description</h3>
                                        <section>
                                            <div class="form-group col-md-12 clearfix">
                                                <label class=" control-label" for="userName2">Category <span class="text-danger">*</span></label>
                                                <!--<select name="category_id" id="category" class="selectpickerr form-control" data-live-search="true" onchange="CustonFields(this)" required>
                                                <option value=""> Select Category</option>-->
                                                <input class="form-control category_name" value="{{ (isset($ad_data['category']['id']))? $ad_data['category']['name'] : '' }}" readonly required type="text" data-toggle="modal" data-target="#categoryModal">
                                                <input id="category" name="category_id" value="{{ (isset($ad_data['category']['id']))? $ad_data['category']['id'] : '' }}" type="hidden">
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12 clearfix">
                                                <label class=" control-label " for="title"> Title <span class="text-danger">*</span></label>
                                                <input id="title" name="title" type="text" value="{{ (isset($ad_data))? $ad_data['title'] : '' }}" class=" form-control" required>
                                            </div>
                                            <div class="form-group col-md-12 clearfix">
                                                <div class="row">
                                                    @if($setting->hide_price == 0)
                                                        <div class="col-md-6">
                                                            <label class=" control-label " for="price"> Price <span class="text-danger">*</span></label>
                                                            <input id="price" name="price" value="{{ (isset($ad_data))? $ad_data['price'] : '' }}"  type="text" class=" form-control" required onkeyup="check_number(this, 'number_only')" onpaste="check_number(this, 'number_only')" autocomplete="off">
                                                            <small class="number_only">Only number allowed!</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <!-- price options  -->
                                                            <div id="price_container" class="hidden">
                                                                <label class=" control-label" for="price_container">Price options <span class="text-danger">*</span></label>
                                                                <select name="price_option" id="price_options" class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input id="price" name="price" value="0" type="hidden">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group  clearfix">
                                                <label class=" control-label m-l-10" for="confirm2">Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="content"  rows="5" required>{{ (isset($ad_data))? $ad_data['description'] : '' }}</textarea>
                                            </div>
                                            <div class="clearfix">
                                                <div id="load_customfields"><!-- Load custom fields --></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </section>
                                        <h3>Images</h3>
                                        <section>
                                            <div class="form-group clearfix">
                                                <div class="col-md-12">
                                                    <input type="file" name="image[]" id="filer_input1" multiple="multiple">
                                                </div>
                                            </div>
                                        </section>
                                        <h3>Verification</h3>
                                        <section>
                                        <?php
                                        if( !Auth::guest() ){
                                            if( isset($ad_data) && Auth::user()->type == 'adm'){
                                                $user = DB::table('users')->whereId($ad_data['user_id'])->first();
                                            }
                                        }
                                        ?>
                                        <!-- user information  -->
                                            <div class="guest">
                                                <div class="content-subheading"><i class="icon-user fa"></i> <strong>Seller information</strong></div>

                                                <div class="form-group clearfix m-b-10">
                                                    <label class="col-md-2 control-label" for="seller-name">Name <span class="text-danger">*</span></label>
                                                    <div class="col-md-10">
                                                        <input id="seller-name"  @unless (!Auth::check()) readonly value="{{ ( isset($user->name) )? $user->name :  Auth::user()->name }}" @endunless name="user_name" placeholder="Seller Name" class="form-control input-md" required type="text">
                                                    </div>
                                                </div>

                                                <div class="form-group clearfix m-b-10">
                                                    <label class="col-md-2 control-label" for="seller-email">Email <span class="text-danger">*</span></label>
                                                    <div class="col-md-10">
                                                        <input id="seller-email" data-login="0" @unless (Auth::check()) name="user_email" @endunless  @unless (!Auth::check()) readonly value="{{ ( isset($user->email) )? $user->email :  Auth::user()->email }}" @endunless class="form-control" placeholder="Email" required type="text">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" value="1" name="show_email">
                                                                <small> View the email address in the ad's listing</small>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group clearfix m-b-10">
                                                    <label class="col-md-2 control-label" for="user_phone">Phone <span class="text-danger">*</span></label>
                                                    <div class="col-md-8">
                                                        <input id="user_phone" name="phone" minlength="10" maxlength="15" @if($setting->mobile_verify != 1) onkeyup="check_number(this, 'phone_number_only')" @endif   placeholder="Phone Number" @unless (!Auth::check()) @if(isset($user->phone) && $user->phone !='' ) value="{{$user->phone}}" disabled @else value="{{ Auth::user()->phone}}" @endif   @endunless class="@unless (!Auth::check()) {{ Auth::user()->mobile_verify ==1 ? 'vfy_phone_number' : '' }}  @endunless  form-control input-md " required type="text" autocomplete="off">
                                                        <small class="phone_number_only">Only number allowed!</small>
                                                    </div>
                                                    @unless ( !Auth::check() )
                                                        @if( Auth::user()->mobile_verify !=1 )
                                                            <div class="col-md-2 hidden send_code_btn">
                                                                <button id="send_code" class="btn btn-success" type="button">Send Code <i class="fa fa-spin fa-spinner hidden"></i></button>
                                                            </div>
                                                        @endif
                                                    @endunless
                                                </div>

                                                <div class="form-group clearfix m-b-10 hidden mobile_code">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-10">
                                                        <p> <i class="fa fa-phone"></i> Enter Four digits code below, send to your phone.</p>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input id="code" name="phone_code" placeholder="Enter code here" type="text" class="form-control valid" aria-invalid="false">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <i class="fa fa-spin fa-spinner v_code_loader hidden"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </section>
                                        <h3>Location</h3>
                                        <section>
                                            <div class="form-group clearfix m-b-10">
                                                <label class="col-md-2 control-label" for="seller-Location">Zip</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" value="{{ (isset($ad_data['zip']) )? $ad_data['zip'] : '' }}" name="zip" autocomplete="off">
                                                    <small class="zip_number_only">Only number allowed!</small>
                                                </div>
                                            </div>

                                            <div class="form-group clearfix m-b-10">
                                                <label class="col-md-2 control-label" for="seller-Location">Address:</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="address" value="{{ (isset($ad_data['address']) )? $ad_data['address'] : '' }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix m-b-10">
                                                <label class="col-md-2 control-label" for="seller-Location">Location <span class="text-danger">*</span></label>
                                                <div class="col-md-10">
                                                    <select id="region_ad" name="region_id" class="form-control" required>
                                                        <option value="" selected>Select Region</option>
                                                        @foreach($region as $value)
                                                            <option {{ (isset($ad_data['region_id']) && $ad_data['region_id'] == $value->id )? 'selected' : '' }}  value="{{$value->id}}"> {{ $value->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="load_city">
                                                <!-- city  -->
                                                @if(isset($ad_data))
                                                    <div class="form-group clearfix m-b-10">
                                                        <label class="col-md-2 control-label" for="seller-area">City <span class="text-danger">*</span></label>
                                                        <div class="col-md-10">
                                                            <?php $city = DB::table('city')->where('region_id', $ad_data['region_id'])->get();  ?>
                                                            <select id="city" name="city_id" class="form-control" required>
                                                                <option value="">Select City</option>
                                                                @foreach($city as $v)
                                                                    <option {{ ($ad_data['city_id'] == $v->id)? 'selected' : '' }} value="{{$v->id}}">{{$v->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($setting->map_listings == 1)
                                                <?php
                                                if(!isset($ad_data)){
                                                    $lat = $lon = '';
                                                    $ip= @$_SERVER['REMOTE_ADDR'];
                                                    $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
                                                    if($query && $query['status'] == 'success') {
                                                        $lon = @$query["lon"];
                                                        $lat = @$query["lat"];
                                                    }
                                                }else{
                                                    $lat = @$ad_data['lat'];
                                                    $lon = @$ad_data['lng'];
                                                }
                                                ?>
                                                <div class="form-group clearfix m-l-15">
                                                    <input type="hidden" id="txtLat" class="disabled form-control" name="lat" value="">
                                                    <input type="hidden" id="txtLng" class="form-control" name="lng" value="">
                                                    <h4 class="m-t-0 header-title"><b>Add Location</b></h4>
                                                    <div id="map"></div>
                                                    <input id="pac-input" type="text" class="form-control controls" placeholder="Search Location">
                                                </div>
                                            @endif


                                            <div class="m-b-30"></div>
                                        </section>

                                        @if(isset($featured) && $featured->status == 1)
                                            <?php $PaymentGateway =  \App\PaymentGateway::first(); ?>
                                            @if( $PaymentGateway->stripe_status == 1 || $PaymentGateway->paypal_status == 1 )

                                            <h3>Payments</h3>
                                            <section>
                                                <div class="card bg-light card-body mb-3 p-20">
                                                    <h3><i class=" icon-certificate icon-color-1"></i> {{ $featured->title }}
                                                    </h3>
                                                    <p>{{ $featured->description }}</p>
                                                    <div class="form-group row">
                                                        <table id="featureTable" class="table table-hover checkboxtable">
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" data-title="Regular List" name="ad_price" id="normal_listing_price" value="{{ $featured->normal_listing_price }}" checked>
                                                                            Regular List
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td><p><strong>${{ $featured->normal_listing_price }}</strong></p></td>
                                                            </tr>

                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" data-title="home page price" name="ad_price" id="home_page_price" value="{{ $featured->home_page_price }}">
                                                                            home page price
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td><p><strong>${{ $featured->home_page_price }} </strong> For {{ $featured->home_page_days }} days.</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" data-title="Urgent Ad" name="ad_price" id="urgent_price" value="{{$featured->urgent_price}}">
                                                                            Urgent Ad
                                                                        </label>
                                                                    </div>

                                                                </td>
                                                                <td><p><strong>${{ $featured->urgent_price }} </strong> For {{ $featured->urgent_days }} days.</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" data-title="Top of the Page Ad" name="ad_price" id="top_page_price" value="{{$featured->top_page_price}}">
                                                                            Top of the Page Ad
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td><p><strong>${{ $featured->top_page_price }} </strong> For {{ $featured->top_page_days }} days.</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" data-title="Top of the Page Ad + Urgent Ad" name="ad_price" id="urgent_top_price" value="{{$featured->urgent_top_price}}">
                                                                            Top of the Page Ad + Urgent Ad
                                                                        </label>
                                                                    </div>

                                                                </td>
                                                                <td><p><strong>${{ $featured->urgent_top_price}} </strong> For {{ $featured->urgent_top_days }} days.</p></td>
                                                            </tr>
                                                            <tr bgcolor="#ccc">
                                                                <td>
                                                                </td>
                                                                <td><p><strong>Payable Amount : $<span class="payableAmount">0</span></strong></p></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <input type='hidden' name="f_type" id="f_type">
                                                    <div class="stripeGateway hidden">
                                                        @if( $PaymentGateway->stripe_status == 1 )

                                                        <div class='form-row'>
                                                            <div class='col-xs-12 form-group card required'>
                                                                <label class='control-label'>Card Number</label>
                                                                <input autocomplete='off' class='form-control card-number' size='20' value="" maxlength="16" type='text' name="card_no">
                                                            </div>
                                                        </div>
                                                        <div class='form-row'>
                                                            <div class='col-md-4 col-xs-6 form-group cvc required'>
                                                                <label class='control-label'>CVV</label>
                                                                <input autocomplete='off' class='form-control card-cvc' maxlength="3" placeholder='ex. 311' value="" size='4' type='text' name="cvvNumber">
                                                            </div>
                                                            <div class='col-md-4 col-xs-6 form-group expiration required'>
                                                                <label class='control-label'>Expiration Month</label>
                                                                <input class='form-control card-expiry-month' placeholder='MM' size='2' value="" type='text' name="ccExpiryMonth">
                                                            </div>
                                                            <div class='col-md-4 col-xs-6 form-group expiration required'>
                                                                <label class='control-label'>Expiration Year</label>
                                                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' value="" type='text' name="ccExpiryYear">
                                                                <input type='hidden' name="featured_amount">

                                                            </div>
                                                        </div>
                                                        <img src="{{ asset('assets/images/card-logos.png') }}" class="img-responsive" style="height: 65px;bottom: 0;position: absolute; right: 0;" alt="">
                                                        @endif
                                                        @if($PaymentGateway->paypal_status == 1)
                                                            <a href="javascript:void(0)" onclick="submitForm()"> <img src="{{ asset('assets/images/btn_paynow.png') }}" alt=""> </a>
                                                                <img src="{{ asset('assets/images/paypal-logo.jpg') }}" class="img-responsive" style="height: 120px; position: absolute; right: 0;" alt="">
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
                                        @endif <!-- end featured if -->
                                    @endif <!-- end featured if -->
                                    </div>
                                </form>
                                @if($PaymentGateway->paypal_status == 1)
                                    <form class="form" id="paypal-form" method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">
                                        <input type="hidden" name="business" value="<?= $PaymentGateway->paypal_email ?>">
                                        <input type="hidden" name="cmd" value="_xclick">
                                        <input type="hidden" name="item_name" value="">
                                        <input type="hidden" name="amount" value="">
                                        <input type="hidden" name="currency_code" value="USD">
                                        <input type="hidden" name="custom" id="custom_data" value="">
                                        <input type="hidden" name="return" value="<?= url('/verify_ad') ?>">
                                        <input type="hidden" name="notify_url" value="<?= url('/verify_ad') ?>">
                                    </form>
                                @endif
                            </div>
                        </div>
                        <!-- End row -->
                    </div>
                </div>
                <div class="col-md-3 reg-sidebar">
                    <div class="reg-sidebar-inner text-center">
                        <div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
                            <h3><strong>Post a Free Classified</strong></h3>
                            <p> Post your free online classified ads with us.</p>
                        </div>
                        <div class="panel sidebar-panel">
                            <div class="panel-heading uppercase">
                                <small><strong>How to sell quickly?</strong></small>
                            </div>
                            <div class="panel-content">
                                <div class="panel-body text-left">
                                    <ul class="list-check">
                                        <li> Use a brief title and description of the item</li>
                                        <li> Make sure you post in the correct category</li>
                                        <li> Add nice photos to your ad</li>
                                        <li> Put a reasonable price</li>
                                        <li> Check the item before publish</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade top-60" id="SignupReqModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modelTitleId">Benefits of Registration</h4>
                </div>
                <div class="modal-body">
                    <div class=" col-md-12">
                        <!-- Start -->
                        <div class="b-registration-info-container">
                            <div class="b-registration-info">
                                <div class="b-registration-info-title">
                                    The Advantages of Registering
                                </div>
                                <div class="b-registration-info-text">
                                    {{ \App\Setting::value('title') }} is the free service, designed to manage your ads in an easy and immediate way.
                                    <ul class="b-rounded-list">
                                        <li>
                                            <div class="b-rounded-list-pointer">
                                                <span>1</span>
                                            </div>
                                            <div class="b-rounded-list-content">
                                                <div class="font-weight-bold">Rapidity</div>
                                                <p>Publish your adverts without waiting for notification by e-mail</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="b-rounded-list-pointer">
                                                <span>2</span>
                                            </div>
                                            <div class="b-rounded-list-content">
                                                <div class="font-weight-bold">Statistics</div>
                                                <p>Analyze ad performance, number of visits and responses</p>
                                            </div>
                                        </li>
                                        <li class="b-last">
                                            <div class="b-rounded-list-pointer">
                                                <span>3</span>
                                            </div>
                                            <div class="b-rounded-list-content">
                                                <div class="font-weight-bold">Visibility</div>
                                                <p>Promote your ads by purchasing the Credit Packages</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary  pull-right" data-dismiss="modal">Close</button>
                    <a href="{{ url('register') }}" class="btn btn-danger btn-xl pull-left"><i class="icon-user-add"></i> Sign Up</a>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="showLoginForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <center><h3 class="modal-title text-center">Already user</h3></center>
                </div>
                <div class="modal-body text-center">
                    <div class="p-25">
                        <p> We found, You already registered.</p>
                        <p>Enter your password to Log In</p>
                        <form action="" id="LoginTop">
                            <div class="form-group">
                                <label for="password">
                                    <input id="login_pass" type="password" class="form-control" name="password" required>
                                </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"> <i class="icon-login"></i> Log in </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal category -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">Select Category <i class="fa fa-spin fa-spinner hidden"></i></h3>
                </div>
                <div class="modal-body">
                    <div class="p-25">
                        <div id="main_category" class="col-md-12">
                            <div class="row row-featured-category">
                                @foreach($parent_cat as $item)
                                    <a href="javascript:;" onclick="loadChildCategories(this)" data-id="{{$item->id}}" data-type="parent">
                                        <div class="col-md-3 col-sm-3 col-xs-3  f-category">
                                            <p>
                                                @if($item->icon !='')
                                                    <i class="{{$item->icon}} fa-2x"></i>
                                                @else
                                                    <img src="{{asset('assets/images/c_icons/'.$item->image.'')}}" alt="" class="img-cat">
                                                @endif
                                            </p>
                                            <p>{{ ucfirst($item->name) }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 row hidden" id="listMainCategory">
                                <?php $is_parent=false;  ?>
                                @foreach($parent_cat as $item)
                                    @if(\App\Category::where('parent_id', $item->id)->value('id') !='' )
                                        <?php $is_parent = true; ?>
                                    @endif
                                    <a href="javascript:;" onclick="{{ $is_parent? 'loadChildCategories(this)':'insertCat('.$item->id.')' }}" data-id="{{$item->id}}" data-type="parent">
                                        <li>{{ ucfirst($item->name) }} {{ $is_parent? '>>' : '' }}</li>
                                    </a>
                                @endforeach
                            </div>
                            <div id="loadChilds" class="hidden"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Mobile verification-->
    <?php
    if(isset($ad_data)){
        $html = '[';
        foreach($ad_data['ad_images'] as $value){
            if($value['image'] !="") {
                $array = explode('.', $value['orignal_filename']);
                $extension = end($array);

                $html = $html . '{ name:' . '"' . $value['orignal_filename'] . '", type: "image/' . $extension . '", file: "'.asset('assets/images/listings/'). '/'. $value['image'] . '", size: 00 },';
            }
        }
        $html = rtrim($html, ',').']';
    }
    ?>
    <input id="is_login" type="hidden" class="hidden" value="0">
    <!--Form Wizard-->
    <script src="{{asset('assets/plugins/jquery.steps/js/jquery.steps.min.js' )}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js' )}}" type="text/javascript"></script>
    <!--wizard initialization-->
    <script src="{{asset('assets/js/jquery.wizard-init.js')}}" type="text/javascript"></script>

    <!-- Jquery filer js -->
    <script src="{{asset('assets/plugins/jquery.filer/js/jquery.filer.min.js')}}"></script>
    <!-- page specific js -->
    <script src="{{ asset('assets/js/jquery.fileuploads.init.js') }}"></script>
    <!-- ck editor -->
    <script src="{!! asset('assets/js/ckeditor/ckeditor.js') !!}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAwX5DJjr0fC7_vp6_WVO6Ut16hXTuK1g&libraries=places&callback=initMap"></script>
    <script>
        var is_paypal='';
        function submitForm(){
            is_paypal = 'yes';
            $('#wizard-validation-form input.category_name').append('<input type="hidden" name="paypal" value="yes" >');

            $('#wizard-validation-form').submit();
        }

        $('#featureTable input[type="radio"]').click(function () {
            var price = $(this).val();
            var item_name = $(this).attr('data-title');
            $('input[name="featured_amount"], #paypal-form input[name="amount"]').val(price);
            $('#paypal-form input[name="item_name"]').val($('#title').val());
            $('.payableAmount').html(price);
        });

        $('#urgent_price, #urgent_top_price, #top_page_price, #home_page_price').click(function () {
            $('.stripeGateway').removeClass('hidden');

            $('.content').attr('style', 'min-height:62em !important');

            $('#f_type').val( $(this).attr('id') );
            @if($PaymentGateway->paypal_status == 1)
            $('.actions ul li:last-child').hide();
            @endif
        });

        $('#normal_listing_price').click(function () {
            $('.stripeGateway').addClass('hidden');
            $('.actions ul li:last-child').show();
        });


        @if($setting->map_listings == 1)
        /* --------------------- Start Google Map */
        var lan = '{{$lon}}';
        var lat = '{{$lat}}';

        if(lan !='' && lat !=''){
            var myLoc = {lat: parseInt(lat)	, lng: parseInt(lan) };
            var myMarker = true;
        }else{
            var myLoc = {lat: 51.509865	, lng: -0.118092 };
        }

        function initMap() {
            var marker;
            var map = new google.maps.Map(document.getElementById('map'), {
                center: myLoc,
                zoom: 3,
                mapTypeId: 'roadmap'
            });
            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });
            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });

                map.fitBounds(bounds);
            });

            google.maps.event.addListener(map, 'click', function(event) {
                if (marker) {
                    marker.setMap(null);    //code
                }
                //adding marker
                document.getElementById('txtLat').value=event.latLng.lat();
                document.getElementById('txtLng').value=event.latLng.lng();
                marker= new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    icon: "{{asset('assets/images/map-marker.png')}}"

                });

            });
            if(myMarker == true){
                marker= new google.maps.Marker({
                    position: myLoc,
                    map: map,
                    icon: "{{asset('assets/images/map-marker.png')}}"
                });
            }
        }
        @endif
        /* -------------------------------- End Google Map  */
        function insertCat(id, title) {
            CustonFields(id);
            $('#category').val(id);
            $('.category_name').val(title);
            $('#P_child a[data-id="'+id+'"] li').css('background', '#f3f3f3');
            $('#categoryModal').modal('hide');
        }

        /*  get child categories */
        function loadChildCategories(e) {
            $('#categoryModal .fa-spinner').removeClass('hidden');
            var id = $(e).attr('data-id');
            var parent = $(e).attr('data-type');
            if(id!=''){
                $.post('{{route('load-child-cat')}}', {id:id}, function (data) {
                    if(data!=''){
                        if(parent == 'parent'){
                            $('.row-featured-category').addClass('hidden');
                            $('#loadChilds').html(data);
                            $('#loadChilds, #listMainCategory').removeClass('hidden');

                            $('#listMainCategory li').css('background', '#fff');
                            $('#listMainCategory a[data-id="'+id+'"] li').css('background', '#f3f3f3');
                        }
                        if(parent == 'child'){
                            $('#loadChilds #P_child').remove();
                            $('#loadChilds div.col-md-4:last-child').after('<div id="P_child">'+data+'</div>');

                            $('#loadChilds li').css('background', '#fff');
                            $('#loadChilds a[data-id="'+id+'"] li').css('background', '#f3f3f3');
                        }
                    }
                    $('#categoryModal .fa-spinner').addClass('hidden');
                });
            }
        }
        var custom_file = <?= (isset($html)? $html:'[]') ?>;
        @if(isset($ad_data))
        $('#category option[value={{ $ad_data['category_id'] }}]').attr('selected','selected');
        @endif
        function check_number (e, cls){
            if (/\D/g.test(e.value)){
                e.value = e.value.replace(/\D/g,'');
                $('.'+cls).addClass('text-danger').removeClass('text-success');
            }else{
                $('.'+cls).removeClass('text-danger').addClass('text-success');
            }
        }
        $(document).ready(function () {
            $('.selectpickerr').selectpicker();
            $('#city').on('change', function () {
                $('#load_comune').html('');
                var id = $(this).val();
                if(id != 0) {
                    $('#loading').show();
                    $.post('{{url('load-comune')}}', {id: id }, function (data) {
                        $('#load_comune').html(data);
                        $('#loading').hide();
                    });
                    $('#loading').hide();
                }
            });
            // load cf
            @if(isset($ad_data['category_id']))
            $('#loading').show();
            var id  = '{{ $ad_data['id']  }}';
            if(id != '') {
                $.post('{{url('load-edited-customfields')}}', {id: id}, function (data) {
                    if(data!=''){
                        $('#load_customfields').html(data);
                    }
                    $('#loading').hide();
                });
            }else{
                $('#loading').hide();
            }
                    @endif

            var element = CKEDITOR.replace('content',{
                    allowedContent: true
                });
            //CKEDITOR.config.resize_enabled = false;

            $('#LoginTop').submit(function () {
                $.post(base_url+'/user-login',
                    { password: $('#login_pass').val(), 'email': $('#seller-email').val()},
                    function(data){
                        if(data!=''){
                            var obj = data;
                            if(obj.msg == 1){
                                $('#seller-name').val(obj.name);
                                $('#seller-name').attr('disabled', true);
                                $('#seller-email').attr('disabled', true);
                                if(obj.phone!='') {
                                    $('#user_phone').val(obj.phone);
                                    $('#user_phone').attr('disabled', true);
                                }
                                $('.actions ul li:nth-child(2)').removeClass('hidden');
                                $('#is_login').val('1');
                                $('#showLoginForm').modal('hide');
                                swal('Success!', 'You are logged in successfully!', 'success');
                            }
                            if(obj.msg == 2){
                                swal('Error!', 'Wrong password provided!', 'error');
                            }
                        }
                    }
                );
                return false;
            });



            /* user phone verify */
                    @if($setting->mobile_verify == 1)

            var veryfy = true;
            $('.steps ul li').click(function () {
                if($('#steps-uid-0-t-2 span:first-child').hasClass('current-info')){

                    @unless ( !Auth::check() )
                            @if( Auth::user()->mobile_verify !=1 )
                    if(veryfy === true){
                        $('.actions ul li:nth-child(2)').hide();
                    }
                    @endif
                    @endunless
                }
            });

            $('#user_phone').on('keyup blur', function(){

                var vl =  $('#user_phone').val();

                if (/^[+()\d]+$/.test(vl)) {
                    /**/
                    $('.phone_number_only').addClass('text-success').removeClass('text-danger');
                } else {
                    $('.phone_number_only').addClass('text-danger').removeClass('text-success');
                    return false;
                }

                if( vl.length >= 10 ){
                    //console.log('ok');

                    $('.send_code_btn').removeClass('hidden');
                }else{
                    $('.send_code_btn').addClass('hidden');
                }
            });

            /* send code to user mobile*/
            $('#send_code').click(function(){

                var phone = $('#user_phone').val();
                var email = $('#seller-email').val();

                if(email ==''){
                    swal('Warning', 'Email field is required', 'warning');
                    $('#seller-email').focus();
                    return false;
                }

                $(this).find('.fa-spinner').removeClass('hidden');
                $.post('{{ route('phone-verify-code') }}',
                    {email:email, phone:phone, _token:'{{csrf_token()}}'},
                    function (result) {

                        if(result.msg==1){
                            $('#user_phone').val(result.number);
                            $('.mobile_code').removeClass('hidden');
                            $('#send_code').addClass('hidden');

                        }else if( result.msg == 2 ){
                            swal('Error', result.error, 'error');
                            $('#user_phone').focus();
                        }

                        $('#send_code').find('.fa-spinner').addClass('hidden');

                    });
            });

            $('#code').keyup(function () {

                var vl =  $('#code').val();
                if(vl.length ==4) {

                    var phone = $('#user_phone').val();
                    var email = $('#seller-email').val();

                    $('.v_code_loader').removeClass('hidden');

                    $.post('{{ route('verify-code') }}',
                        { code:vl, email: email, phone: phone, _token: '{{csrf_token()}}'},
                        function (result) {

                            if (result.msg == 1) {
                                $('#user_phone').attr('style', 'border: 2px solid #02c102 !important');
                                $('.mobile_code').html('<center class="text-success"> Phone number verified successfully! </center>');
                                $('.actions ul li:nth-child(2)').show();
                                veryfy = false;
                            } else if (result.msg == 2) {
                                swal('Error', result.error, 'error');
                            }

                            $('.v_code_loader').addClass('hidden');
                        });
                }
            });
            @endif

            //
            @if(Auth::guest())
            $('#seller-email').on('blur', function() {
                var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
                var email = $(this).val();
                var is_login = $('#is_login').val();
                // alert( pattern.test(emailAddress) );
                //console.log(is_login);
                if(is_login==0){
                    if (pattern.test(email)) {
                        $('.actions ul li:nth-child(2)').removeClass('hidden');
                        // valid email
                        $.post(base_url + '/check_email',
                            {email: email},
                            function (data) {
                                if (data != '2') {
                                    $('#showLoginForm').modal('show');
                                    $('.actions ul li:nth-child(2)').addClass('hidden');
                                } else {
                                    $(this).css('background-color', 'white');
                                }
                            }
                        )
                    } else {
                        swal('Error!', 'Invalid email!', 'error');
                        $(this).css('background-color', 'pink');
                        $('.actions ul li:nth-child(2)').addClass('hidden');
                    }
                }
            });
            @endif
            // set height of div
            $('.actions ul li:nth-child(2),#steps-uid-0-t-1, #steps-uid-0-t-2,#steps-uid-0-t-3').click(function () {

                if($(this).parent('li').hasClass('current')){
                    //console.log('ok');
                    $('.content').attr('style', 'min-height:45em!important');
                }

                // $('.content').attr('style', 'min-height:35em');
            });
            $('.actions ul li:first-child, #steps-uid-0-t-0').click(function () {
                var chk_class = $('.actions ul li:first-child').attr('class');
                if(chk_class == 'disabled'){
                    //var Height = $('#content_height').val();
                    // $('.content').attr('style', Height);
                }
            });
            // add empty option to category select
            //$('select[name="category_id"] option:first-child').before('<option selected value=""> Select Category</option>');

            // ajax submit form
            $("#wizard-validation-form").submit(function(){
                $('#loading').show();
                var data = new FormData(this);
                data.append('description', CKEDITOR.instances.content.getData());
                $.ajax({
                    url: "{{route('ads.store')}}",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(result){
                        if(result.msg == 1 || result.msg == 4){
                            if(is_paypal == 'yes'){
                                $('#custom_data').val(result.ad_id);

                                $('#paypal-form').submit();
                            }else{
                                // error
                                window.location.href=base_url+'/ad-message/'+result.msg;
                            }
                        }

                        if(result.msg == 'admin_ad' ){
                            swal("Success!", "Ad Posted successfully", "success");
                            window.location.href=base_url+'/my-ads';
                        }
                        if(result.msg == 'not_admin' ){
                            swal("Success!", "Ad Posted successfully", "success");
                            window.location.href=base_url+'/ads';
                        }
                        if(result.msg == 'fill_required'){
                            swal("Error!", "Please fill all cards fields", "error");
                        }else if(result.msg == 'error' || result.msg == 'error_f'){
                            swal("Error!", "Your card information is incorrect, payment is not made!", "error");
                        }else
                            if(result.msg == 2){
                                swal("Error!", result.error, "error");
                            }
                        else{
                            // error
                            //swal("Error!", "Something went wrong.", "error");
                        }
                        $('#loading').hide();
                    }
                });
                return false;
            });

            $('#region_ad').on('change', function () {
                $('#load_city, #load_comune').html('');
                var id = $(this).val();
                if(id != 0) {
                    $.post('{{url('load-city')}}', {id: id}, function (data) {
                        $('#load_city').html(data);
                    });
                }
            });
            // load modal
            @if(Auth::guest())
            $('#SignupReqModel').modal('show');
            @endif
        });
        // load Cf,
        function CustonFields(id){
            $('#loading').show();
            $('#load_customfields').html('');

            if(id != '') {
                // get price options
                $.get('{{url('load-price_option')}}', {id: id}, function (result) {
                    if(result !=''){
                        $('#price_container').removeClass('hidden');
                        $('#price_container #price_options').html('<option value=""> Select Options</option>');
                        $.each(result, function (item, val){
                            $('#price_options option:first-child').after('<option value="'+val+'"> '+val+' </option>');
                        });
                    }else{
                        $('#price_container').addClass('hidden');
                    }
                });
                // get fields
                $.post('{{url('load-customfields')}}', {id: id}, function (data) {
                    if(data!=''){
                        $('#load_customfields').html(data);
                    }
                    $('#loading').hide();
                });

            }else{
                $('#loading').hide();
            }
        }
    </script>
@endsection
