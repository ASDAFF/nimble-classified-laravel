@extends('admin.layout.app')
@section('content')
<?php
    $setting = DB::table('setting')->first();

?>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Dashboard</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li><a href="{{ url('dashboard') }}">Home</a> </li>
                                <li class="active"> Featured Ads Settings</li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-xxs-12">
                        <div class="panel panel-color panel-inverse">
                            <div class="panel-heading">
                                <h3 class="panel-title">Featured Ads Settings</h3>
                            </div>
                            <div class="panel-body">
                                <form action="" id="featuredAdsForm">
                                    {{csrf_field()}}
                                    <input type="hidden" id="featuredAdsId" name="id" value="{{ isset($featured_ads->id)? $featured_ads->id : ''}}">
                                    <div class="form-group">
                                        <lable>Title</lable>

                                        <input type="text" class="form-control" name="title" required value="{{ isset($featured_ads->title)? $featured_ads->title : ''}}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>normal ads price</lable>
                                                <input type="text" readonly onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="normal_listing_price" value="{{ isset($featured_ads->normal_listing_price)? $featured_ads->normal_listing_price : 0}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Home Page ads price</lable>
                                                <input type="text" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="home_page_price" value="{{ isset($featured_ads->home_page_price)? $featured_ads->home_page_price : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Home Page ads days</lable>
                                                <input type="number" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="home_page_days" value="{{ isset($featured_ads->home_page_days)? $featured_ads->home_page_days : ''}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Top on Page ads price</lable>
                                                <input type="text" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="top_page_price" value="{{ isset($featured_ads->top_page_price)? $featured_ads->top_page_price : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Top on Page ads days</lable>
                                                <input type="number" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="top_page_days" value="{{ isset($featured_ads->top_page_days)? $featured_ads->top_page_days : ''}}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Urgent ads price</lable>
                                                <input type="text" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="urgent_price" value="{{ isset($featured_ads->urgent_price)? $featured_ads->urgent_price : ''}}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Urgent ads days</lable>
                                                <input type="number" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="urgent_days" value="{{ isset($featured_ads->urgent_days)? $featured_ads->urgent_days : ''}}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Urgent plus top page price</lable>
                                                <input type="text" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="urgent_top_price" value="{{ isset($featured_ads->urgent_top_price)? $featured_ads->urgent_top_price : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <lable>Urgent plus top page days</lable>
                                                <input type="number" onkeyup="this.value=this.value.replace(/[^\d.]/,'')" onkeydown="this.value=this.value.replace(/[^\d.]/,'')" class="form-control" name="urgent_top_days" value="{{ isset($featured_ads->urgent_top_days)? $featured_ads->urgent_top_days : ''}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <lable> Detail </lable>
                                        <textarea name="description" class="form-control" id="" rows="5">{{ isset($featured_ads->description)? $featured_ads->description : ''}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="status" name="status" type="checkbox" value="1" {{ isset($featured_ads->status) && $featured_ads->status == 1  ? 'checked' : ''}}>
                                            <label for="status" class="text-bold">Status</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success"> Save </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="panel panel-color panel-inverse">
                            <div class="panel-heading">
                                <h3 class="panel-title">Payment Processor Settings</h3>
                            </div>
                            <div class="panel-body">
                                <div class="alert alert-info"><strong>Note!</strong> Only one payment processor can be activated. </div>
                                <h3> Stripe Settings </h3>
                                <hr>

                                <form action="" id="stripeForm">
                                    <input type="hidden" name="id" id="gatewayId" value="{{ isset($paymentGateway)&& $paymentGateway->id !='' ? $paymentGateway->id : '' }}">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <lable>Publishable Key</lable>
                                        <input type="text" name="stripe_publishable_key" value="{{ isset($paymentGateway)&& $paymentGateway->stripe_publishable_key !='' ? $paymentGateway->stripe_publishable_key : '' }}" class="form-control" placeholder="Enter publish key">
                                    </div>

                                    <div class="form-group">
                                        <lable>Secret Key</lable>
                                        <input type="text" name="stripe_secret_key" value="{{ isset($paymentGateway)&& $paymentGateway->stripe_secret_key !='' ? $paymentGateway->stripe_secret_key : '' }}" class="form-control" placeholder="Enter secret key">
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="stripe_status" name="stripe_status" type="checkbox" value="1" {{ isset($paymentGateway->stripe_status) && $paymentGateway->stripe_status == 1  ? 'checked' : ''}}>
                                            <label for="stripe_status" class="text-bold">Status</label>
                                        </div>
                                        <br>
                                        <br>
                                        <strong>To get App credentials, please create app on Stripe from <a href="https://stripe.com/" target="_blank">here</a></strong>

                                    </div>
                                    <hr>
                                    <h3> Paypal Settings </h3>
                                    <hr>
                                    <div class="form-group">
                                        <lable>Paypal Email</lable>
                                        <input type="text" name="paypal_email" value="{{ isset($paymentGateway)&& $paymentGateway->paypal_email !='' ? $paymentGateway->paypal_email : '' }}" class="form-control" placeholder="Enter your business email" >
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="paypal_status" name="paypal_status" type="checkbox" value="1" {{ isset($paymentGateway->paypal_status) && $paymentGateway->paypal_status == 1  ? 'checked' : ''}}>
                                            <label for="paypal_status" class="text-bold">Status</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success btn-sm">Save</button>
                                        <br>
                                        <br>
                                        <strong>To get App credentials, please create app on Paypal from <a href="https://www.paypal.com" target="_blank">here</a></strong>
                                        <br>
                                        <p class="label label-danger"> <strong>
                                          Make Sure Redirect to Application URL after payment is enabled.
                                        </strong> </p>

                    										<div>
                                          <ol>
                                            <li>Re: Redirect to new URL after payment</li>
                                            <li>Go to the PayPal website and log in to your account.</li>
                                            <li>Click "Profile" at the top of the page.</li>
                                            <li>Click the "Website Payment Preferences" link in the Selling Preferences column.</li>
                                            <li>Click the Auto Return "On" button.</li>
                                            <li>Review the Return URL Requirements.</li>
                                            <li>Copy this Url {{url('/verify_ad')}} and Enter to the Return URL. </li>
                                            <li>Click "Save.</li>
                                          </ol>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
        <script>

            $(document).ready(function () {
                $('#paypal_status').click(function () {
                    if( $(this).is(":checked")  ){
                        $('#stripe_status').prop("checked", false);
                    }else{
                        $('#paypal_status').prop("checked", true);
                    }
                });

                $('#stripe_status').click(function () {
                    if( $(this).is(":checked")  ){
                        $('#paypal_status').prop("checked", false);
                    }else{
                        $('#stripe_status').prop("checked", true);
                    }
                });


               $('#featuredAdsForm').submit(function () {
                   var data = new FormData(this);
                   $.ajax({
                       url: "{{ route('featured-ads.store') }}",
                       data: data,
                       contentType: false,
                       processData: false,
                       type: 'POST',
                       success: function(result){
                           if(result.msg == 1){
                            $('#paypalId').val(result.id);
                            swal('Success', 'Settings saved successfully!', 'success');
                           }
                           $('#loading').hide();
                       }
                   });
                return false;
               });

               $('#stripeForm').submit(function () {
                   var data = new FormData(this);
                   $.ajax({
                       url: "{{ route('save-payment-gateway') }}",
                       data: data,
                       contentType: false,
                       processData: false,
                       type: 'POST',
                       success: function(result){
                           if(result.msg == 1){
                            swal('Success', 'Stripe settings saved successfully!', 'success');
                           }
                           $('#loading').hide();
                       }
                   });
                return false;
               });


            });

        </script>
@endsection
