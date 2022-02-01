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
                <div class="category-list section">
                    <div class="tab-box ">
                        <ul class="nav nav-tabs add-tabs" id="ajaxTabs" role="tablist">

                            @if (session('error'))
                                <span class="label label-danger m-l-10">{{ session('error') }}</span>
                            @endif
                        </ul>

                    </div>

                    <div class="listing-filter">
                        <div class="pull-left col-xs-6">
                            <h3 class="page-title"> All users ads  </h3>
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
                                    <?php
                                    if( strlen($v->title) > 35 ){
                                        $ad_title = substr($v->title, 0,35) . '..';
                                    }else{
                                        $ad_title = $v->title;
                                    }
                                    $user_type = \App\User::where('id', $v->user_id)->value('type');
                                    ?>
                                    <!-- urgent top page price -->
                                        @if($v->f_type == 'top_page_price' || $v->f_type == 'urgent_top_price')

                                            <div class="ad-item row">
                                                <!-- item-image -->
                                                <div class="item-image-box col-sm-4">
                                                    <div class="item-image">
                                                        <a href="{{url('single/'.urlencode( str_slug($v->title.'-'.$v->id) ) )}}"><img src="{!! asset('assets/images/listings/'.(isset($v->ad_images[0]->image)? $v->ad_images[0]->image : 'empty.jpg').'') !!}" alt="Image" class="img-responsive"></a>
                                                    </div><!-- item-image -->
                                                </div>
                                                <!-- rending-text -->
                                                <div class="item-info col-sm-8">
                                                    <!-- ad-info -->
                                                    <!-- ad-info -->
                                                    <div class="ad-info">
                                                        @if($setting->hide_price==0)
                                                            <h3 class="item-price pull-right">{{  $setting->currency_place == 'left' ? $setting->currency : ''  }}{{ number_format($v->price) }} {{  $setting->currency_place == 'right' ? $setting->currency : ''  }}</h3>
                                                        @endif
                                                        <h4 class="item-title"><a href="{{url('single/'.urlencode( str_slug($v->title.'-'.$v->id) ) )}}">{{ ucfirst($ad_title) }}</a></h4>
                                                        <div class="item-cat">
                                                            <span class="dated"><a href="javascript:void(0)"> <i class="fa fa-clock-o"></i> {{ $v->created_at->diffForHumans() }}</a></span>
                                                            - <span class="category">{{ $v->category->name }} </span>-
                                                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ floor($v->visit/2) }} Ads view "><i class="fa fa-eye" aria-hidden="true"> {{ floor($v->visit/2) }}</i></span>
                                                            - <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ floor($v->message) }} Message "><i class="fa fa-envelope-o" aria-hidden="true"> {{ floor($v->message) }}</i></span>

                                                        </div>
                                                        @foreach($v->ad_cf_data as $data)
                                                            @if($data->column_value!='')
                                                                <span class="label label-default">@if($data->icon!='' || $data->image !='')  {!! ($data->icon!='')? '<i class="'.$data->icon.'"></i>' : '<img src="'.asset('assets/images/c_icons/'.$data->image.'').'" height="38" width="30" >' !!} @endif {{ ucfirst(str_replace('_', ' ', $data->column_name)) }}: <span class="m-r-5 p-5"> {{$data->column_value}}</span></span>
                                                            @endif
                                                        @endforeach
                                                    </div><!-- ad-info -->

                                                    <!-- ad-meta -->
                                                    <div class="ad-meta">
                                                        <div class="meta-content">
                                                            @if(!Auth::guest())
                                                                <a class="save-add"  data-action="{{ (count($v->save_add) > 0)? 'del': 'ins' }}" data-id="{{$v->id}}" href="javascript:void(0)" title="" >
                                                                    @if(count($v->save_add) > 0)
                                                                        <span class="fa fa-star"></span>
                                                                        <span class="text">Add Saved</span>
                                                                    @else
                                                                        <span class="fa fa-star-o"></span>
                                                                        <span class="text">Save Add</span>
                                                                    @endif
                                                                    <span class=" hidden fa fa-spinner fa-spin"></span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <!-- item-info-right -->
                                                        <div class="user-option pull-right">
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title=" ad's images"><i class="fa fa-camera"></i> {{ count($v->ad_images) }} </a>
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ ucwords( $v->city->title ) }}"><i class="fa fa-map-marker"></i> </a>
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $user_type == 'u' || $user_type == 'adm'? 'private' : 'Company' }}"><i class="fa {{ $user_type == 'u' || $user_type == 'adm'? 'fa-briefcase' : 'fa-user' }}"></i> </a>

                                                            <a href="javascript:void(0)" class="saved-job">
                                                                @if($v->is_login)
                                                                    <i data-toggle="tooltip" title="Online" class="fa fa-circle text-success"></i>
                                                                @else
                                                                    <i data-toggle="tooltip" title="Offline" class="fa fa-circle text-danger"></i>
                                                                @endif
                                                            </a>

                                                        </div><!-- item-info-right -->
                                                    </div><!-- ad-meta -->
                                                </div><!-- item-info -->
                                            </div>
                                        @endif

                                        @if($v->f_type == 'urgent_price' || $v->f_type == '' || $v->f_type == 'home_page_price')
                                            <div class="listings-item row">
                                                <div class="item-image-box col-sm-4">
                                                    <!-- item-image -->
                                                    <div class="item-image">
                                                        @if($v->f_type == 'urgent_price')
                                                            <span class="featured-listings">Urgent</span>
                                                        @endif
                                                        @if(isset($v->user->is_verified) && $v->user->is_verified==2)
                                                            <a href="javascript:void(0)" class="verified" data-toggle="tooltip" data-placement="left" title="" data-original-title="Verified"><i class="fa fa-check-square-o"></i></a>
                                                        @endif
                                                        <a href="{{url('single/'.urlencode( str_slug($v->title.'-'.$v->id) ) )}}"><img src="{!! asset('assets/images/listings/'.(isset($v->ad_images[0]->image)? $v->ad_images[0]->image : 'empty.jpg').'') !!}" alt="Image" class="img-responsive"></a>

                                                    </div><!-- item-image -->
                                                </div><!-- item-image-box -->
                                                <!-- rending-text -->
                                                <div class="item-info col-sm-8">
                                                    <!-- ad-info -->
                                                    <!-- ad-info -->
                                                    <div class="ad-info">
                                                        @if($setting->hide_price==0)
                                                            <h3 class="item-price pull-right">{{  $setting->currency_place == 'left' ? $setting->currency : ''  }}{{ number_format($v->price) }} {{  $setting->currency_place == 'right' ? $setting->currency : ''  }}</h3>
                                                        @endif
                                                        <h4 class="item-title"><a href="{{url('single/'.urlencode( str_slug($v->title.'-'.$v->id) ) )}}">{{ ucfirst($ad_title) }}</a></h4>
                                                        <div class="item-cat">
                                                            <span class="dated"><a href="javascript:void(0)"> <i class="fa fa-clock-o"></i> {{ $v->created_at->diffForHumans() }}</a></span>
                                                            - <span class="category">{{ $v->category->name }} </span>-
                                                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ floor($v->visit/2) }} Ads view "><i class="fa fa-eye" aria-hidden="true"> {{ floor($v->visit/2) }}</i></span>
                                                            - <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ floor($v->message) }} Message "><i class="fa fa-envelope-o" aria-hidden="true"> {{ floor($v->message) }}</i></span>

                                                        </div>
                                                        @foreach($v->ad_cf_data as $data)
                                                            @if($data->column_value!='')
                                                                <span class="label label-default">@if($data->icon!='' || $data->image !='')  {!! ($data->icon!='')? '<i class="'.$data->icon.'"></i>' : '<img src="'.asset('assets/images/c_icons/'.$data->image.'').'" height="38" width="30" >' !!} @endif {{ ucfirst(str_replace('_', ' ', $data->column_name)) }}: <span class="m-r-5 p-5"> {{$data->column_value}}</span></span>
                                                            @endif
                                                        @endforeach
                                                    </div><!-- ad-info -->

                                                    <!-- ad-meta -->
                                                    <div class="ad-meta">
                                                        <div class="meta-content">
                                                            @if(!Auth::guest())
                                                                <a class="save-add"  data-action="{{ (count($v->save_add) > 0)? 'del': 'ins' }}" data-id="{{$v->id}}" href="javascript:void(0)" title="" >
                                                                    @if(count($v->save_add) > 0)
                                                                        <span class="fa fa-star"></span>
                                                                        <span class="text">Add Saved</span>
                                                                    @else
                                                                        <span class="fa fa-star-o"></span>
                                                                        <span class="text">Save Add</span>
                                                                    @endif
                                                                    <span class=" hidden fa fa-spinner fa-spin"></span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <!-- item-info-right -->
                                                        <div class="user-option pull-right">
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title=" ad's images"><i class="fa fa-camera"></i> {{ count($v->ad_images) }} </a>
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ ucwords( $v->city->title ) }}"><i class="fa fa-map-marker"></i> </a>
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $user_type == 'u' || $user_type == 'adm'? 'private' : 'Company' }}"><i class="fa {{ $user_type == 'u' || $user_type == 'adm'? 'fa-briefcase' : 'fa-user' }}"></i> </a>

                                                            <a href="javascript:void(0)" class="saved-job">
                                                                @if($v->is_login)
                                                                    <i data-toggle="tooltip" title="Online" class="fa fa-circle text-success"></i>
                                                                @else
                                                                    <i data-toggle="tooltip" title="Offline" class="fa fa-circle text-danger"></i>
                                                                @endif
                                                            </a>

                                                        </div><!-- item-info-right -->
                                                    </div><!-- ad-meta -->
                                                </div><!-- item-info -->
                                            </div><!-- ad-listings -->
                                        @endif
                                    @endforeach
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

                <div class="post-promo text-center m-b-20">
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

