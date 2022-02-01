@extends('layouts.app')
@section('content')
<style>
    .img-cat{ height:28px; width: 38px; }
    .form-control{ background-color: white!important;}
    .slider img{
        min-height: 140px !important;
        width: 270px!important;
    }
    .featured .ad-info {
        min-height: 175px;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">

<?php
// settings
$setting = DB::table('setting')->first();
function buildCategory($parent, $category) {
    //print_r($category['parent_cats'][$parent]);
    $html = $bold = "";
    if (isset($category['parent_cats'][$parent])) {
        $html .= "";
        foreach ($category['parent_cats'][$parent] as $cat_id) {
            if (!isset($category['parent_cats'][$cat_id])) {
                $html .= "<option value='".$cat_id."'>" .ucfirst($category['categories'][$cat_id]['name']). "</option>";
            }
            if (isset($category['parent_cats'][$cat_id])) {
                if($category['categories'][$cat_id]['parent_id'] == 0){
                    $html .= "<optgroup label='" . ucfirst($category['categories'][$cat_id]['name']) . "'>";
                }else{
                    $html .= "<option  value='".$cat_id."'> " .ucfirst($category['categories'][$cat_id]['name']). "</option>";
                }
                //$html .= "<optgroup label='" . ucfirst($category['categories'][$cat_id]['name']) . "'>";
                $html .= buildCategory($cat_id, $category);
                $html .= "</optgroup>";
            }
        }
        $html .= "";
    }
    $html .='';
    return $html;
}
?>

<!-- main -->
<section id="main" class="clearfix home-default">
    <div class="container">
        <!-- banner -->
        <div class="banner-section text-center">
            <h1 class="title">World's Largest Classifieds Portal </h1>
            <h3>Search from over 15,00,000 classifieds & Post unlimited classifieds!</h3>
            <!-- banner-form -->
            <div class="banner-form">
                <form action="{{url('search/query')}}" method="get">
                    <!-- category-change -->
                    <input type="text" class="form-control" name="keyword" placeholder="Type Your key word">
                    <select name="region" id="region" class="form-control locinput input-rel searchtag-input has-icon selecters">
                        <option value="">Select Region</option>
                        @foreach($region as $value)
                            <option value="{{ $value->id }}">{{ ucfirst($value->title) }}</option>
                        @endforeach
                    </select>

                    <select name="category" style="height:48px" class="form-control locinput input-rel has-icon" id="category" required>
                        <option value=""> Select Category</option>
                        {!! buildCategory(0, $category) !!}
                        {{--<input class="form-control" id="category" name="category" readonly type="text" data-toggle="modal" data-target="#categoryModal">--}}
                    </select>

                    <button type="submit" class="form-control" value="Search">Search</button>
                </form>
            </div><!-- banner-form -->
        @if($setting->social_links == 1)
            <!-- banner-socail -->
                <ul class="banner-socail list-inline">
                    @if($setting->facebook !='')
                        <li><a href="{{ $setting->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    @endif
                    @if($setting->twitter !='')
                        <li><a href="{{ $setting->twitter }}" target="_blank"> <i class="fa fa-twitter"></i> </a></li>
                    @endif
                    @if($setting->googleplus !='')
                        <li><a href="{{ $setting->googleplus }}" target="_blank"><i class="fa fa-google-plus"></i> @else</a></li>
                    @endif
                    @if($setting->linkedin !='')
                        <li><a href="{{ $setting->linkedin }}" target="_blank"><i class="fa fa-linkedin"></i></a><li>
                    @endif
                </ul><!-- banner-socail -->
        @endif


    @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
    @endif
    <div class="main-content">
        <!-- row -->
        <div class="row">
            <div class="hidden-xs hidden-sm col-md-2 text-center">
                @if( isset($setting) && $setting->home_ads  == 1 && $setting->home_ads_p == 'bs' )
                    <div class="advertisement">
                        {!! $setting->home_adsense !!}
                    </div>
                @endif
            </div>
            <!-- product-list -->
            <div class="col-md-8">
                <!-- categorys -->
                <div class="section category-listings text-center">
                    <ul class="category-list">
                        @foreach($parent_cat as $item)
                            <a href="{{url('search/query?main_category='.urlencode($item->slug))}}">
                                <li class="category-item">
                                        <div class="category-icon">
                                            @if($item->icon !='')
                                                <i class="{{$item->icon}} fa-2x"></i>
                                            @else
                                                <img src="{{asset('assets/images/c_icons/'.$item->image.'')}}" alt="" class="img-cat">
                                        </div>
                                            @endif
                                        <span class="category-title">{{ ucwords($item->name) }}</span>

                                </li><!-- category-item -->
                            </a>
                        @endforeach
                    </ul>
                </div><!-- category-ad -->

                @if( isset($setting->home_ads) && $setting->home_ads  == 1 && $setting->home_ads_p == 'r' )
                    <div class="advertisement text-center">
                        {!! $setting->home_adsense !!}
                    </div>
                @endif

                <?php $featured_ads = DB::table('featured_ads')->first(); ?>
                @if( isset( $featured_ads->status) && count( $home_ads ) > 0  && $featured_ads->status == 1 )
                <!-- featureds -->
                <div class="section featureds">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section-title featured-top">
                                <h4>Featured Ads</h4>
                            </div>
                        </div>
                    </div>
                    <!-- featured-slider -->
                    <div class="featured-slider">
                        <div id="featured-slider" >
                            <!-- featured -->
                            @foreach($home_ads as $h_ads)
                                <?php
                                $href = url('single/'.urlencode( str_slug($h_ads->title.'-'.$h_ads->id) ) ) ;
                                $User = \App\User::where('id', $h_ads->user_id)->first();
                                ?>
                            <div class="featured">
                                <div class="featured-image">
                                    <a href="{{$href}}"><img src="{{ asset('assets/images/listings/'.$h_ads->image) }}" alt="" class="img-respocive"></a>
                                    @if(@$User->is_verified == 1 || @$User->mobile_verify == 1)
                                    <a href="{{$href}}" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
                                    @endif
                                    <span class="featured-ad">Featured</span>
                                </div>
                                <!-- ad-info -->
                                <div class="ad-info">
                                    <h3 class="item-price">{{  $setting->currency_place == 'left' ? $setting->currency : ''  }}{{ number_format($h_ads->price) }} {{  $setting->currency_place == 'right' ? $setting->currency : ''  }}</h3>
                                    <h4 class="item-title"><a href="{{ $href }}">{{ ucfirst( substr($h_ads->title, 0, 50) ) }}..</a></h4>
                                    <div class="item-cat">
                                        <span><a href="{{ $href }}">{{ \App\Category::where('id', $h_ads->category_id)->value('name') }}</a></span>
                                    </div>
                                </div><!-- ad-info -->

                                <!-- ad-meta -->
                                <div class="ad-meta">
                                    <div class="meta-content">
                                        <span class="dated"><a href="{{ $href }}">{{ date('d M H:i A', strtotime($h_ads->created_at)) }} </a></span>
                                    </div>
                                    <!-- item-info-right -->
                                    <div class="user-option pull-right">
                                        <a href="{{ $href }}" data-toggle="tooltip" data-placement="top" title="{{ $h_ads->address }}"><i class="fa fa-map-marker"></i> </a>
                                        <a href="{{ $href }}" data-toggle="tooltip" data-placement="top" title="{{ @$User->type == 'u' || @$User->type == 'adm' ? 'individual' : 'Dealer' }}"><i class="fa {{ @$User->type == 'u' || @$User->type == 'adm' ? 'fa-user' : 'fa-suitcase' }}"></i> </a>
                                    </div><!-- item-info-right -->
                                </div><!-- ad-meta -->
                            </div><!-- featured -->
                            @endforeach

                        </div><!-- featured-slider -->
                    </div><!-- #featured-slider -->
                </div><!-- featureds -->
            @endif
                @if( isset($featured_ads->status) && $featured_ads->status == 0)
                    @if( count($newAds) > 0 )s
                    <div class="section trending-ads">
                    <div class="section-title tab-manu">
                        <h4>Latest Ads </h4>
                    </div>

                    <!-- Tab panes -->
                            @foreach($newAds as $item)
                                <?php
                                $href = url('single/'.urlencode( str_slug($item->title.'-'.$item->id) ) ) ;
                                $User = \App\User::where('id', $item->user_id)->first();
                                ?>
                            <div class="listings-item row">
                                <!-- item-image -->
                                <div class="item-image-box col-sm-4">
                                    <div class="item-image">
                                        <a href="{{$href}}"><img src="{{ asset('assets/images/listings/'.$item->image) }}" alt="" class="img-respocive"></a>
                                        @if(@$User->is_verified == 1 || @$User->mobile_verify == 1)
                                        <a href="{{ $href }}" class="verified" data-toggle="tooltip" data-placement="left" title="Verified"><i class="fa fa-check-square-o"></i></a>
                                            <span class="featured-ad">Featured</span>
                                        @endif
                                    </div><!-- item-image -->
                                </div>

                                <!-- rending-text -->
                                <div class="item-info col-sm-8">
                                    <!-- ad-info -->
                                    <!-- ad-info -->
                                    <div class="ad-info text-left">
                                        <h3 class="item-price">{{  $setting->currency_place == 'left' ? $setting->currency : ''  }}{{ number_format($item->price) }} {{  $setting->currency_place == 'right' ? $setting->currency : ''  }}</h3>
                                        <h4 class="item-title"><a href="{{ $href }}">{{ ucfirst($item->title) }}</a></h4>
                                        <div class="item-cat">
                                            <span><a href="{{ $href }}">{{ \App\Category::where('id', $item->category_id)->value('name') }}</a></span>
                                        </div>
                                    </div><!-- ad-info -->

                                    <!-- ad-meta -->
                                    <div class="ad-meta">
                                        <div class="meta-content">
                                            <span class="dated"><a href="{{ $href }}">{{ date('d M H:i A', strtotime($item->created_at)) }} </a></span>
                                        </div>
                                        <!-- item-info-right -->
                                        <div class="user-option pull-right">
                                            <a href="{{ $href }}" data-toggle="tooltip" data-placement="top" title="{{ $item->address }}"><i class="fa fa-map-marker"></i> </a>
                                            <a href="{{ $href }}" data-toggle="tooltip" data-placement="top" title="{{ @$User->type == 'u' || @$User->type == 'adm' ? 'individual' : 'Dealer' }}"><i class="fa {{ @$User->type == 'u' || @$User->type == 'adm' ? 'fa-user' : 'fa-suitcase' }}"></i> </a>
                                        </div><!-- item-info-right -->
                                    </div><!-- ad-meta -->
                                </div><!-- item-info -->
                            </div>
                            @endforeach

                </div>
                @endif
            @endif

                <!-- cta -->
            </div><!-- product-list -->
            @if( isset($setting->home_ads) && $setting->home_ads  == 1 && $setting->home_ads_p == 'as' )
            <!-- advertisement -->
            <div class="hidden-xs hidden-sm col-md-2">
                <div class="advertisement text-center">
                    {!! $setting->home_adsense !!}
                </div>
            @endif
            </div><!-- advertisement -->
        </div><!-- row -->
    </div><!-- banner -->
            <!-- main-content -->
</div><!-- main-content -->
</div><!-- container -->
</section><!-- main -->

<section class="footer-top ">
    @if(count($regionAds) > 0)
        <div class="container">
            <div class="featured-top">
                <h4> <i class="fa fa-map-marker"></i> TOP LOCATIONS</h4>
            </div>
            <div class="">
                @foreach($regionAds as $val)
                    <div class=" col-md-2 col-sm-3 col-xs-6">
                        <a class="btn btn-sm btn-default btn-block m-b-5" href="{{ url('search/query') }}?region={{ $val->id }}"> <span class="text-right pull-left"> {{$val->title}}</span> <span class="badge pull-right">{{ \App\Ads::where(['region_id' => $val->id, 'status' => 1])->count() }}</span> <span class="clearfix"></span></a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>

<section id="download" class="clearfix parallax-section">
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-sm-3 text-center m-b-20 col-xs-6 col-xxs-12 text-white" >
                <i class="fa fa-user fa-3x"></i>
                <span class="font-20"> {{ number_format( \App\User::where(['type' => 'u'])->count() ) }} </span>
                <h4>Trusted Seller</h4>
                <!--/.iconbox-wrap-->
            </div>

            <div class="col-sm-3 text-center m-b-20 col-xs-6 col-xxs-12 text-white">
                <i class="fa fa-list-ol fa-3x"></i>
                <span class="font-20"> {{ number_format( \App\Category::where('parent_id', '!=', 0)->count() ) }} </span>
                <h4>Categories</h4>
                <!--/.iconbox-wrap-->
            </div>
            <div class="col-sm-3 text-center m-b-20 col-xs-6  col-xxs-12 text-white">
                <i class="fa fa-map-marker fa-3x"></i>
                <span class="font-20"> {{ number_format(\App\City::count()) }} </span>
                <h4>Location</h4>
            </div>
            <div class="col-sm-3 text-center m-b-20 col-xs-6 col-xxs-12 text-white">
                <i class="fa fa-file-image-o fa-3x"></i>
                <span class="font-20"> {{ number_format( \App\Ads::where(['status' => 1])->count() ) }} </span>
                <h4>Active Ads</h4>
            </div>
        </div>
    </div><!-- contaioner -->
</section>
@endsection