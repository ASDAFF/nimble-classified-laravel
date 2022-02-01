@extends('layouts.app')
@section('content')
    <style>
        .inner-page {
            padding-top: 35px;
        }
    </style>
<?php
$setting = DB::table('setting')->first();
// check user is company
$avator = asset('assets/images/users/male.png');
if($result[0]->user->image ==''){
    if($result[0]->user->type == 'c' ){
        $avator = asset('assets/images/users/company.png');
    }
    if($result[0]->user->type == 'u' ){
        if($result[0]->user->gender == 'm'){
            $avator = asset('assets/images/users/male.png');
        }
        if($result[0]->user->gender == 'f'){
            $avator = asset('assets/images/users/female.png');
        }
    }
}else{
    $avator = asset('assets/images/users/'.$result[0]->user->image.'');
}
?>
<div class="main-container  m-t-20">
    <div class="container">
        @if($setting->profile_ads  == 1 && $setting->profile_ads_p == 'ah' )
            <div class="ads_bs m-b-10">
                {!! $setting->profile_adsense !!}
            </div>
        @endif
        <div class="row">
            <div class="col-sm-9 page-content">
                <div class="category-list">
                    <div class="tab-box ">
                        <ul class="nav nav-tabs add-tabs" id="ajaxTabs" role="tablist">
                            @if (session('error'))
                                <span class="label label-danger m-l-10">{{ session('error') }}</span>
                            @endif
                        </ul>
                    </div>

                    <div class="listing-filter">
                        <div class="pull-left col-xs-6">
                            <div class="breadcrumb-list"><a href="javascript:void(0)" class="current"> <span>All user ads</span></a>
                            </div>
                        </div>
                        <div class="pull-right col-xs-6 text-right listing-view-action">
                            <span class="list-view active"><i class="  icon-th"></i></span>
                            <span class="compact-view"><i class=" icon-th-list  "></i></span>
                            <span class="grid-view "><i class=" icon-th-large "></i></span>
                        </div>
                        <!--<form action="" id="custom_data">-->
                        @foreach($search_fields as $item)
                            <div class="col-md-3">
                                <label for="">{{ucfirst($item->name)}}:</label>
                                <select name="custom_search[{{ strtolower( str_replace(' ', '_', $item->name) ) }}]" form="search_form" onchange="$('#search_form').submit()" class="form-control">
                                    <option value="">All {{ucfirst($item->name)}} </option>
                                    @foreach(explode(',', $item->options) as $value)
                                        <option @if(isset($_REQUEST['custom_search'][strtolower( str_replace(' ', '_', $item->name) )]) && $value == $_REQUEST['custom_search'][strtolower( str_replace(' ', '_', $item->name) )]) selected @endif       value="{{$value}}">{{ ucwords($value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach
                            <!--</form>-->
                            <div class="clearfix"></div>
                    </div>

                    <div class="menu-overly-mask"></div>
                    <div class="adds-wrapper">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                @if(count($result) > 0)
                                    @foreach($result as $v)
                                        <div class="item-list make-list" style="">
                                            <!--<div class="cornerRibbons topAds">
                                                <a href="#"> Top Ads</a>
                                            </div>-->
                                            <div class="col-md-2 no-padding photobox">
                                                <div class="add-image"><span class="photo-count">
                                                            <i class="fa fa-camera"></i> {{ count($v->ad_images) }} </span>
                                                    <a href="{{url('single/'.urlencode(strtolower(str_slug( $v->title.'-'.$v->id, '-')))  )}}">
                                                        <img class="thumbnail no-margin" src="{!! asset('assets/images/listings/'.(isset($v->ad_images[0]->image)? $v->ad_images[0]->image : 'empty.jpg').'') !!}" alt="img">
                                                    </a>
                                                </div>
                                            </div>
                                            <!--/.photobox-->
                                            <div class="col-sm-8 add-desc-box col-md-7">
                                                <div class="ads-details">
                                                <h5 class="add-title"><a href="{{url('single/'.urlencode(strtolower(str_slug( $v->title.'-'.$v->id, '-')))  )}}">{{ ucfirst($v->title) }} </a></h5>
                                                <span class="info-row">
                                                    <!--<span class="add-type business-ads tooltipHere" data-toggle="tooltip" data-placement="right" title="Business Ads">B </span>-->
                                                    <span class="date"><i class=" icon-clock"> </i> {{ $v->created_at->diffForHumans() }} </span>
                                                    - <span class="category">{{ $v->category->name }} </span>-
                                                    <span class="item-location"><i class="fa fa-map-marker"></i> {{ ucwords( $v->city->title ) }}</span>
                                                    - <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ floor($v->visit/2) }} Ads view "><i class="fa fa-eye" aria-hidden="true"> {{ floor($v->visit/2) }}</i></span>
                                                    - <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ floor($v->message) }} Message "><i class="fa fa-envelope-o" aria-hidden="true"> {{ floor($v->message) }}</i></span>
                                                </span>
                                                </div>
                                                <div class="ads-details m-t-10">
                                                    @foreach($v->ad_cf_data as $data)
                                                        @if($data->column_value!='')
                                                            <span class="label label-default">@if($data->icon!='' || $data->image !='')  {!! ($data->icon!='')? '<i class="'.$data->icon.'"></i>' : '<img src="'.asset('assets/images/c_icons/'.$data->image.'').'" height="38" width="30" >' !!} @endif <strong>{{ ucfirst(str_replace('_', ' ', $data->column_name)) }}: </strong><span class="m-r-5 p-5"> {{$data->column_value}}</span></span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!--/.add-desc-box-->
                                            <div class="col-md-3 text-right  price-box">
                                                @if($setting->hide_price == 0)
                                                <h2 class="item-price text-danger"> {{  $setting->currency_place == 'left' ? $setting->currency : ''  }}{{ number_format($v->price) }} {{  $setting->currency_place == 'right' ? $setting->currency : ''  }}</h2>
                                                @endif

                                                @if($v->user->is_verified==2)
                                                    <a class="btn bg-white  btn-sm btn-auths" > <img src="{{ asset('assets/img/vfy.png') }}" title="Verified user" alt="" height="22px"> <span>Verified user</span> </a>
                                                @endif

                                            </div>
                                            <!--/.add-desc-box-->
                                            <div class="job-actions pull-right">
                                                <ul class="list-unstyled list-inline">
                                                    @if(!Auth::guest())
                                                        <li>
                                                            <a class="save-add"  data-action="{{ (count($v->save_add) > 0)? 'del': 'ins' }}" data-id="{{$v->id}}" href="javascript:void(0)" title="" >
                                                                @if(count($v->save_add) > 0)
                                                                    <span class="fa fa-star"></span>
                                                                    <span class="text">Add Saved</span>
                                                                @else
                                                                    <span class="fa fa-star-o"></span>
                                                                    <span class="text">Save Ad</span>
                                                                @endif
                                                                <span class=" hidden fa fa-spinner fa-spin"></span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li class="saved-job">
                                                        @if($v->user->is_login)
                                                            <a class=""> <i class="fa fa-circle text-success"></i> <span>Online</span> </a>
                                                        @else
                                                            <a class=""> <i class="fa fa-circle text-danger"></i> <span>Offline</span> </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="lable label-danger p-20 font-white text-center">
                                        Result not found!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--<div class="tab-box  save-search-bar text-center"><a href="javascript:void(0)"> <i class=" icon-star-empty"></i>Save Search </a></div>-->
                </div>
                <div class="pagination-bar text-center">
                    {{--{{ $result->links() }}--}}
                    @if(count($result) > 0)
                        {{ $result->appends(request()->query())->links() }}
                    @endif
                </div>

                <div class="post-promo text-center">
                    <h2> Do you get anything for sell ? </h2>
                    <h5>Sell your products online FOR FREE. It's easier than you think !</h5>
                    <a href="{{route('ads.create')}}" class="btn btn-lg btn-border btn-post btn-danger">Post a Free Ad </a>
                </div>
            </div>
            <div class="col-sm-3  page-sidebar-right">
                <aside>
                    <div class="panel sidebar-panel panel-contact-seller">
                        <div class="panel-heading">Contact Dealer</div>
                        <div class="panel-content user-info">
                            <div class="panel-body">
                                <div class="seller-info" style="position: relative">
                                    <div class="company-logo-thumb col-md-6 row">
                                        <a><img src="{{ $avator }}" class="thumbnail" alt="img"> </a>
                                    </div>
                                    <div class="company-logo-thumb col-md-9 row">
                                        <div class="m-l-5">
                                            <h3 class="no-margin"> {{ ucwords($result[0]->user->name) }}</h3>
                                            @if($result[0]->user->is_verified == 2)
                                                <div class="btn btn-xs btn-success"> Verified User </div>
                                            @endif
                                            @if($result[0]->user->mobile_verify == 1)
                                                <div class="btn btn-xs m-t-5 btn-success">Phone Verified</div>
                                            @endif
                                            <i> {!!  ($result[0]->user->is_login == 1)? '<span class="label label-success">Online</span>' : '<span class="label label-danger">Offline</span>' !!} </i>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="text-leftt clearfix">

                                        @if($result[0]->user->type == 'c')
                                            @if($result[0]->user->telephone)
                                                <p>Telephone: <strong>{{ ucfirst($result[0]->user->telephone) }}</strong></p>
                                            @endif
                                            @if($result[0]->user->fax)
                                                <p>FAx: <strong>{{ ucfirst($result[0]->user->fax) }}</strong></p>
                                            @endif
                                            @if($result[0]->user->address)
                                                <p>Location: <strong>{{ ucfirst($result[0]->user->address) }}</strong></p>
                                            @endif
                                        @endif

                                        <?php
                                            $user_rated = '';
                                            $rating = DB::table('user_rating')
                                                ->select(DB::raw('count(score) as total, AVG(score) as avg'))
                                                ->where('user_id', $result[0]->user->id)->first();
                                        ?>
                                            <div id="rating" data-read="true" data-score="{{ floor($rating->avg) }}" class="click" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if( $setting->profile_ads == 1 && $setting->profile_ads_p == 'r' )
                        <div class="inner-box">
                            <!-- ads box -->
                            {!! $setting->profile_adsense !!}
                        </div>
                    @endif
                    <div class="panel sidebar-panel">
                        <div class="panel-heading">Safety Tips for Buyers</div>
                        <div class="panel-content">
                            <div class="panel-body text-left">
                                <ul class="list-check">
                                    <li> Meet seller at a public place</li>
                                    <li> Check the item before you buy</li>
                                    <li> Pay only after collecting the item</li>
                                </ul>
                                <!--<p><a class="pull-right" href="javascript:void(0);"> Know more <i class="fa fa-angle-double-right"></i> </a></p>-->
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
    <script src="{{asset('assets/js/cookie.js')}}"></script>
    <!-- Rating js -->
    <script src="{{asset('admin_assets/plugins/raty-fa/jquery.raty-fa.js')}}"></script>
    <script>
        // start chat function
        $('.chathead').on('click', function () {

            var forchat = $(this).data('for');
            $('#target').val(forchat);

            $.cookie("chatHead", '{{ $result[0]->user->id }}', { path: '/' });
            $.cookie("chatUser", '{{ ucwords($result[0]->user->name) }}', { path: '/' });

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
        var hint = '{{$rating->total}} votes, average {{ floor($rating->avg) }} out of 5';
        (function ($) {
            $(function () {
                $('.click').raty({
                    readOnly: function(){
                        return $(this).attr('data-read');
                    },
                    score: function () {
                        return $(this).attr('data-score');
                    },
                    half: true,
                    hints: [hint, hint, hint, hint, hint]
                });
            });
        })(jQuery);
</script>
@endsection
