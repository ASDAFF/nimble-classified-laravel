@extends('admin.layout.app')
@section('title', 'Setting')
@section('content')
    <link href="{{ asset('admin_assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <style>
        form#add_category .loader {
            float: right;
            margin-left: 5px;
            margin-top: 6px;
        }
        form#add_category .loader img{
            display: none;
        }
        .file_hidden{
            display: none !important;
        }
        #preview_profile{
            display: block;
            height: 60px;
            margin-bottom: 10px;
        }

    </style>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li> <a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="active"> Adsense Settings </li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-xs-12">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="col-xs-12">
                    <div class="row">
                        <div class="panel panel-color panel-inverse">
                            <div class="panel-heading">
                                <h3 class="panel-title">Adsense Settings</h3>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" id="setting" method="post" action="{{ url('adsense-store') }}"  enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ (isset($data->id) && $data->id != "")? $data->id :''  }}">

                                    <div class="p-l-r-10">
                                        <div class="form-group">
                                            <div class=" m-b-10">
                                                <label for="header_script" class="text-bold">Add Header Code</label>
                                                <textarea class="form-control" name="header_script" id="header_script" placeholder="add header code here">{!!  @$data->header_script !!}</textarea>
                                            </div>

                                            <div class=" m-b-10">
                                                <label for="footer_script" class="text-bold">Add Footer Code</label>
                                                <textarea class="form-control" name="footer_script" id="footer_script" placeholder="add footer code here">{!!  @$data->footer_script !!}</textarea>
                                            </div>

                                            <div class="checkbox checkbox-success m-b-10">
                                                <input name="home_ads" id="home_ads" type="checkbox" value="1" {{ (isset($data->home_ads) && $data->home_ads == 1)? 'checked' : '' }}>
                                                <label for="home_ads" class="text-bold">Homepage adsense</label>
                                            </div>

                                            <div id="home_page_editor" class="{{ (isset($data->home_ads) && $data->home_ads == 0)? 'hidden' : '' }}">

                                                <!-- placement options -->
                                                <div class=" m-b-10">
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio1" {{ ($data->home_ads_p == 'bs')? 'checked' : '' }} value="bs" name="home_ads_p" >
                                                        <label for="inlineRadio1"> Place before search form  </label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio2" {{ ($data->home_ads_p == 'as')? 'checked' : '' }} value="as" name="home_ads_p" >
                                                        <label for="inlineRadio2"> Place after search form </label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio3" {{ ($data->home_ads_p == 'r')? 'checked' : '' }} value="r" name="home_ads_p" >
                                                        <label for="inlineRadio3"> Place Right side</label>
                                                    </div>
                                                </div>

                                                <label>Adsense code</label>
                                                <textarea name="home_adsense" id="home_page"  class="form-control">{!!  $data->home_adsense !!}</textarea>
                                            </div>

                                            <div class="checkbox checkbox-success m-b-10">
                                                <input id="search_ads" name="search_ads" type="checkbox" value="1" {{ (isset($data->search_ads) && $data->search_ads == 1)? 'checked' : ''   }}>
                                                <label for="search_ads" class="text-bold">Search page adsense</label>
                                            </div>

                                            <div id="search_page_editor" class="{{ (isset($data->search_ads) && $data->search_ads == 0)? 'hidden' : '' }}">
                                                <!-- placement options -->
                                                <div class=" m-b-10">
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio4" {{ ($data->search_ads_p == 'bs')? 'checked' : '' }} value="bs" name="search_ads_p" >
                                                        <label for="inlineRadio4"> Place before search form  </label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio5" {{ ($data->search_ads_p == 'as')? 'checked' : '' }} value="as" name="search_ads_p" >
                                                        <label for="inlineRadio5"> Place after search form </label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio6" {{ ($data->search_ads_p == 'r')? 'checked' : '' }} value="r" name="search_ads_p" >
                                                        <label for="inlineRadio6"> Place Right side</label>
                                                    </div>
                                                </div>
                                                <label for="search_ads">Adsense code</label>
                                                <textarea name="search_adsense" id="search_page"  class="form-control">{!!  $data->search_adsense !!}</textarea>
                                            </div>

                                            <div class="checkbox checkbox-success m-b-10">
                                                <input name="profile_ads" id="profile_ads" type="checkbox" value="1" {{ (isset($data->profile_ads) && $data->profile_ads == 1)? 'checked' : ''   }}>
                                                <label for="profile_ads" class="text-bold">Profile page adsense</label>
                                            </div>

                                            <div id="profile_page_editor" class="{{ (isset($data->profile_ads) && $data->profile_ads == 0)? 'hidden' : '' }}">
                                                <!-- placement options -->
                                                <div class=" m-b-10">

                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio7" {{ ($data->profile_ads_p == 'ah')? 'checked' : '' }} value="ah" name="profile_ads_p" >
                                                        <label for="inlineRadio7">After header</label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio8" {{ ($data->profile_ads_p == 'r')? 'checked' : '' }} value="r" name="profile_ads_p" >
                                                        <label for="inlineRadio8"> Place Right side</label>
                                                    </div>
                                                </div>

                                                <label for="profile_ads">Adsense code</label>
                                                <textarea name="profile_adsense" id="profile_page"  class="form-control">{!!  $data->profile_adsense !!}</textarea>
                                            </div>
                                            <div class="checkbox checkbox-success m-b-10">
                                                <input id="single_ads" name="single_ads" type="checkbox" value="1" {{ (isset($data->single_ads) && $data->single_ads == 1)? 'checked' : '' }}>
                                                <label for="single_ads" class="text-bold">Add detail page adsense</label>
                                            </div>
                                            <div id="single_page_editor" class="{{ (isset($data->single_ads) && $data->single_ads == 0)? 'hidden' : '' }}">
                                                <!-- placement options -->
                                                <div class=" m-b-10">
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio10" {{ ($data->single_ads_p == 'ah')? 'checked' : '' }} value="ah" name="single_ads_p" >
                                                        <label for="inlineRadio10">After header</label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        <input type="radio" id="inlineRadio11" {{ ($data->single_ads_p == 'r')? 'checked' : '' }} value="r" name="single_ads_p" >
                                                        <label for="inlineRadio11"> Place Right side</label>
                                                    </div>
                                                </div>
                                                <label for="single_ads">Adsense code</label>
                                                <textarea name="single_adsense" id="single_page"  class="form-control">{!!  $data->single_adsense !!}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group account-btn m-t-10">
                                        <label class=" control-label"></label>
                                        <div class="col-xs-10">
                                            <button class="btn w-md btn-bordered btn-info waves-effect waves-light" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{!! asset('assets/js/ckeditor/ckeditor.js') !!}"></script>
    <script>

        $(document).ready(function() {
            // ck editor1
            CKEDITOR.replace('home_page',{
                allowedContent: true
            });
            // ck editor2
            CKEDITOR.replace('search_page',{
                allowedContent: true
            });
            // verify_success
            CKEDITOR.replace('profile_page',{
                allowedContent: true
            });
            // verify_danger
            CKEDITOR.replace('single_page',{
                allowedContent: true
            });

            // status tags add
            $('input[name="home_ads"]').click(function(){
                if(!$(this).is(":checked")){
                    $('#home_page_editor').addClass('hidden');
                }else{
                    $('#home_page_editor').removeClass('hidden');
                }
            });

            $('input[name="search_ads"]').click(function(){
                if(!$(this).is(":checked")){
                    $('#search_page_editor').addClass('hidden');
                }else{
                    $('#search_page_editor').removeClass('hidden');
                }
            });

            $('input[name="search_ads"]').click(function(){
                if(!$(this).is(":checked")){
                    $('#search_page_editor').addClass('hidden');
                }else{
                    $('#search_page_editor').removeClass('hidden');
                }
            });
            $('input[name="single_ads"]').click(function(){
                if(!$(this).is(":checked")){
                    $('#single_page_editor').addClass('hidden');
                }else{
                    $('#single_page_editor').removeClass('hidden');
                }
            });

            $('input[name="profile_ads"]').click(function(){
                if(!$(this).is(":checked")){
                    $('#profile_page_editor').addClass('hidden');
                }else{
                    $('#profile_page_editor').removeClass('hidden');
                }
            });



        });

    </script>

@endsection
