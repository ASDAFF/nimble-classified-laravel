@extends('layouts.app')
@section('content')
<style>
    .img-cat{ height:28px; width: 38px; }
    .form-control{ background-color: white!important;}
    .slider img{
        min-height: 140px !important;
        width: 270px!important;
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
    <div class="main_bg">
        <div class="dtable hw100">
            <div class="dtable-cell hw100">
                <div class="container m-b-30">
                    @if( isset($setting) && $setting->home_ads  == 1 && $setting->home_ads_p == 'bs' )
                        <div class="ads_bs">
                            {!! $setting->home_adsense !!}
                        </div>
                    @endif
                    <form action="{{url('search/query')}}" method="get">
                        <div class="row search-row animated fadeInUp">
                            <div class="col-lg-3 col-sm-3 search-col relative"><i class="icon-docs icon-append"></i>
                                <input type="text" name="keyword" class="form-control has-icon" placeholder="Keyword" value="">
                            </div>
                            <div class="col-lg-3 col-sm-3 search-col relative locationicon">
                                <i class="icon-location-2 icon-append"></i>
                                <select name="region" id="region" class="form-control locinput input-rel searchtag-input has-icon selecters">
                                    <option value="">Select Region</option>
                                    @foreach($region as $value)
                                        <option value="{{ $value->id }}">{{ ucfirst($value->title) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-3 search-col relative">
                                {{--{!! $category !!}--}}
                                <i class="icon  icon-th icon-append"></i>
                                <select name="category" style="height:48px" class="form-control locinput input-rel has-icon" id="category" required>
                                    <option value=""> Select Category</option>
                                    {!! buildCategory(0, $category) !!}
                                    {{--<input class="form-control" id="category" name="category" readonly type="text" data-toggle="modal" data-target="#categoryModal">--}}
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-3 search-col">
                                <button class="btn btn-danger btn-search btn-block"><i class="icon-search"></i><strong>Find</strong></button>
                            </div>
                        </div>
                    </form>
                        @if( isset($setting->home_ads) && $setting->home_ads  == 1 && $setting->home_ads_p == 'as' )
                            <div class="ads_bs">
                                {!! $setting->home_adsense !!}
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="container">
            <div id="hidden_main_cat" class="col-md-12  p-20">
                <center><h2><span>Browse by</span> Category </h2></center>
                <div class="row-featured-category">
                    @foreach($parent_cat as $item)
                        <a href="{{url('search/query?main_category='.urlencode($item->slug))}}">
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
            </div>
            <div class=" p-b-10 page-content">
            @if( isset($setting))
             @if( $setting->home_ads_p != 'r' || $setting->home_ads == 0 )
                <div class=" p-b-10 page-content">
             @else
                <div class=" p-b-10 page-content col-md-9">
             @endif
            @endif

            <div id="MainCategory" class="box-title no-border">
                <div class="inner">
                    <h2><span>Browse by</span> Category </h2>
                </div>
            </div>
                <div id="MainCategory">
                    <div class="row-featured-category">
                        @foreach($parent_cat as $item)
                            <a href="{{url('search/query?main_category='.urlencode($item->slug))}}">
                            <div class="col-md-3 col-sm-3 col-xs-3  f-category">
                                <p>
                                    @if($item->icon !='')
                                        <i class="{{$item->icon}} fa-3x"></i>
                                    @else
                                        <img src="{{asset('assets/images/c_icons/'.$item->image.'')}}" alt="" class="img-cat">
                                    @endif
                                </p>
                                <p>{{ ucfirst($item->name) }}</p>
                            </div>
                        </a>
                    @endforeach
                    </div>
                </div>
            </div>
            @if( isset($setting->home_ads) && $setting->home_ads  == 1 && $setting->home_ads_p == 'r' )
                <div class="col-sm-3 page-sidebar col-thin-left">
                    <aside>
                        <div class="inner-box">
                            {!! $setting->home_adsense !!}
                        </div>
                        <div class="inner-box no-padding"><img class="img-responsive" src="images/add2.jpg" alt="">
                        </div>
                    </aside>
                </div>
            @endif
        </div>
        <!-- slider  -->

    <div class="clearfix" style="clear: both"></div>

        <?php $featured_ads = DB::table('featured_ads')->first(); ?>
            @if( isset( $featured_ads->status) && count( $home_ads ) > 0  && $featured_ads->status == 1 )
            <div class="col-xl-12 content-box m-t-20">
                <div class=" row-featured">
                    <div class="col-xl-12  box-title ">
                        <div class="inner p-l-r-10">
                            <h2>
                                <span>Featured </span> Ads
                            </h2>
                        </div>
                    </div>
            <!--/.item-list-->
                    @foreach($home_ads as $h_ads)
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="item-list" style="min-height: 311px;padding:20px">
                                <div class="row">
                                    <div class="no-padding photobox">
                                        <div class="add-image"><span class="photo-count"><i class="fa fa-camera"></i> {{ \App\AdsImages::where('ad_id', $h_ads->id)->count() }} </span>
                                            <a href="{{url('single/'.urlencode(strtolower(str_slug($h_ads->title.'-'.$h_ads->id, '-'))) )}}">
                                                <img height="200" class=" no-margin" src="{{ asset('assets/images/listings/'.$h_ads->image) }}" alt="img">
                                            </a>
                                        </div>
                                    </div>
                                    <a class="pull-left" href="{{url('single/'.urlencode(strtolower(str_slug($h_ads->title.'-'.$h_ads->id, '-'))) )}}"><strong> {{ ucfirst( substr($h_ads->title, 0, 50) ) }}.. </strong> </a>
                                    <a class="pull-right" href="{{url('single/'.urlencode(strtolower(str_slug($h_ads->title.'-'.$h_ads->id, '-'))) )}}"> <strong> {{  $setting->currency_place == 'left' ? $setting->currency : ''  }}{{ number_format($h_ads->price) }} {{  $setting->currency_place == 'right' ? $setting->currency : ''  }} </strong> </a>
                                    <div class="clearfix"></div>
                                    <!--/.add-desc-box-->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <div class="clearfix" style="clear: both"></div>

   @if( isset($featured_ads->status) && $featured_ads->status == 0)
        @if( count($newAds) > 0 )
        <div class="col-xl-12 content-box m-t-20">
            <div class=" row-featured">
                <div class="col-xl-12  box-title ">
                    <div class="inner p-l-r-10">
                        <h2>
                            <span>LATEST </span> LISTINGS
                        </h2>
                    </div>
                </div>

                <div style="clear: both"></div>
                <div class=" relative  content featured-list-row  w100">
                    <div class="slider autoplay">
                        @foreach($newAds as $ad)
                        <div class="multiple">
                            <a href="{{url('single/'.urlencode(strtolower(str_slug($ad->title.'-'.$ad->id, '-')))  )}}">
                            <img class="img-responsive" src="{{ asset('assets/images/listings/'.$ad->image) }}" alt="img" style="height: 100px !important;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
        @if( count( $regionAds ) > 0 )
        <div class="col-xl-12 content-box m-t-20">
            <div class=" row-featured">
                <div class="col-xl-12  box-title ">
                    <div class="inner p-l-r-10">
                        <h2>
                            <span><i class="icon-location-2"></i> Top Locations</span>
                        </h2>
                    </div>
                </div>
                <div class="col-xl-12 tab-inner">
                    <div class="row cat-list arrow">
                        @foreach($regionAds as $val)
                        <li class="cat-list col-md-3  col-md-6 col-xxs-12">
                            <a href="{{ url('search/query') }}?region={{ $val->id }}"> {{$val->title}} <small class="label label-success">{{ \App\Ads::where(['region_id' => $val->id, 'status' => 1])->count() }}</small></a>
                        </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="page-info stat_bg m-t-20" style="background-size: cover!important;background-position: bottom;">
        <div class="bg-overly">
            <div class="container text-center section-promo">
                <div class="row">
                    <div class="col-sm-3 col-xs-6 col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <i class="icon  icon-group"></i>
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>{{ number_format( \App\User::where(['type' => 'u'])->count() ) }}</span></h5>
                                    <div class="iconbox-wrap-text">Trusted Seller</div>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>

                    <div class="col-sm-3 col-xs-6 col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <i class="icon  icon-th-large-1"></i>
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>{{ number_format( \App\Category::where('parent_id', '!=', 0)->count() ) }}</span></h5>

                                    <div class="iconbox-wrap-text">Categories</div>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>
                    <div class="col-sm-3 col-xs-6  col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <i class="icon  icon-map"></i>
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>{{ number_format(\App\City::count()) }}</span></h5>
                                    <div class="iconbox-wrap-text">Location</div>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>
                    <div class="col-sm-3 col-xs-6 col-xxs-12">
                        <div class="iconbox-wrap">
                            <div class="iconbox">
                                <div class="iconbox-wrap-icon">
                                    <img src="{{asset('assets/images/spk-icon.png')}}" alt="ad-icon" height="40">
                                </div>
                                <div class="iconbox-wrap-content">
                                    <h5><span>{{ number_format( \App\Ads::where(['status' => 1])->count() ) }}</span></h5>
                                    <div class="iconbox-wrap-text"> Active Ads </div>
                                </div>
                            </div>
                            <!-- /..iconbox -->
                        </div>
                        <!--/.iconbox-wrap-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/slick.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.autoplay').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
        })
    </script>

@endsection
