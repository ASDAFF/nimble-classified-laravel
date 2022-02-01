@extends('admin.layout.app')
@section('content')
<style>
    .label {
        margin-right: 2px;
    }
</style>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li> <a href="{{ url('/home') }}">Dashboard</a></li>
                        <li class="active"> Email Settings </li>
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
                                <h3 class="panel-title">Email Settings</h3>
                            </div>
                            <div class="panel-body">
                                <div class="alert alert-info"> Mail Settings </div>
                                <form action="" method="post" id="EmailSettings" autocomplete="off">
                                    {{ csrf_field() }}
                                    <div class="form-group col-md-6">
                                        <label for=""> APPLICATION NAME </label>
                                        <input type="text" class="form-control" name="APP_NAME" value="{{ trim( $mail['APP_NAME'] ) }}" required  autocomplete="off"  onkeyup="replaceIt(this)" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL FROM ADDRESS </label>
                                        <input type="text" class="form-control" name="MAIL_FROM_ADDRESS" value="{{ trim( $mail['MAIL_FROM_ADDRESS'] ) }}" required  autocomplete="off" onkeyup="replaceIt(this) "/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL FROM NAME </label>
                                        <input type="text" class="form-control" name="MAIL_FROM_NAME" value="{{ trim( $mail['MAIL_FROM_NAME'] ) }}" required  autocomplete="off" onkeyup="replaceIt(this) "/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL DRIVER </label>
                                        <input type="text" class="form-control" name="MAIL_DRIVER" value="{{ trim( $mail['MAIL_DRIVER'] ) }}" required  autocomplete="off" onkeyup="replaceIt(this) "/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL HOST </label>
                                        <input type="text" class="form-control" name="MAIL_HOST" value="{{ trim( $mail['MAIL_HOST'] ) }}" required  autocomplete="off" onkeyup="replaceIt(this) "/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL PORT </label>
                                        <input type="text" class="form-control" name="MAIL_PORT" value="{{ trim( $mail['MAIL_PORT'] ) }}" required  autocomplete="off" onkeyup="replaceIt(this) "/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL USERNAME </label>
                                        <input type="text" class="form-control" name="MAIL_USERNAME" value="{{ trim( $mail['MAIL_USERNAME'] ) }}" required  autocomplete="off" onkeyup="replaceIt(this) "/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL PASSWORD </label>
                                        <input type="text" class="form-control" name="MAIL_PASSWORD" value="{{ trim( $mail['MAIL_PASSWORD'] ) }}" required  autocomplete="off" onkeyup="replaceIt(this) "/>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> MAIL ENCRYPTION </label>
                                        <input type="text" class="form-control" name="MAIL_ENCRYPTION" value="{{ trim( $mail['MAIL_ENCRYPTION'] ) }}" autocomplete="off"  onkeyup="replaceIt(this)" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for=""> TEST EMAIL </label>
                                        <input type="email" class="form-control" name="email" id="test_email" placeholder="Enter test email id" required  autocomplete="off"/>
                                        <small>  </small>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button class="btn btn-success"> Test Email </button>
                                </form>
                                <br>
                                <hr>
                                <div class="col-md-12">
                                    <form class="form-horizontal" role="form" id="email_settings" >
                                        {{ csrf_field() }}

                                        <input type="hidden" name="id" value="{{ (isset($data->id) && $data->id !="")? $data->id :''  }}">

                                        <div class="form-group">
                                            <div class="alert alert-info">Guest Registration Notification</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Subject:</label>
                                            <input id="registration_subject" name="registration_subject" placeholder="Enter subject " value="{!! (isset($data->registration_subject)) ? $data->registration_subject : '' !!}" class="form-control" required autocomplete="off" >
                                        </div>

                                        <div class="form-group ">
                                            <label class="control-label">Content:</label>

                                            <textarea class="form-control" id="registration_content" rows="5" placeholder="some details" > {!! (isset($data->registration_content)) ? $data->registration_content : '' !!}</textarea>
                                            <div class="register">
                                                <a href="javascript:void(0)"> <span class="label label-success"> %name% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-info"> %email% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-danger"> %password% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-warning"> %status% </span> </a>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="alert alert-info">Status Notification</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Subject:</label>
                                            <input id="status_subject" name="status_subject" placeholder="Enter subject " value="{!! (isset($data->status_subject)) ? $data->status_subject : '' !!}" class="form-control" autocomplete="off" >
                                        </div>

                                        <div class="form-group ">
                                            <label class="control-label">Content:</label>
                                            <textarea class="form-control" id="status_content" rows="5" placeholder="some details" > {!! (isset($data->status_content)) ? $data->status_content : '' !!}</textarea>
                                            <div class="status">
                                                <a href="javascript:void(0)"> <span class="label label-success"> %name% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-info"> %email% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-danger"> %password% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-warning"> %status% </span> </a>
                                            </div>
                                        </div>
                                        <!-- Identity Verified  -->
                                        <div class="form-group">
                                            <div class="alert alert-success">Identity Verified Notification</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Subject:</label>
                                            <input id="status_subject" name="verify_success_subject" placeholder="Enter subject " value="{!! (isset($data->verify_success_subject)) ? $data->verify_success_subject : '' !!}" class="form-control" autocomplete="off" >
                                        </div>

                                        <div class="form-group ">
                                            <label class="control-label">Content:</label>
                                            <textarea class="form-control" id="verify_success" rows="5" placeholder="some details" > {!! (isset($data->verify_success_content)) ? $data->verify_success_content : '' !!}</textarea>
                                            <div class="verify_success">
                                                <a href="javascript:void(0)"> <span class="label label-success"> %name% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-info"> %email% </span> </a>
                                            </div>
                                        </div>
                                        <!-- Identity Un-Verified  -->
                                        <div class="form-group">
                                            <div class="alert alert-danger">Identity Un-verified Notification</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Subject:</label>
                                            <input id="status_subject" name="verify_danger_subject" placeholder="Enter subject" value="{!! (isset($data->verify_danger_subject)) ? $data->verify_danger_subject : '' !!}" class="form-control" autocomplete="off" >
                                        </div>

                                        <div class="form-group ">
                                            <label class="control-label">Content:</label>
                                            <textarea class="form-control" id="verify_danger" rows="5" placeholder="some details" > {!! (isset($data->verify_danger_content)) ? $data->verify_danger_content : '' !!}</textarea>
                                            <div class="verify_danger">
                                                <a href="javascript:void(0)"> <span class="label label-success"> %name% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-info"> %email% </span> </a>
                                            </div>
                                        </div>

                                      <!-- Expiry  -->
                                        <div class="form-group">
                                            <div class="alert alert-danger"> Expiry Ads Notification </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Subject:</label>
                                            <input id="status_subject" name="expiry_ads_subject" placeholder="Enter subject" value="{!! (isset($data->expiry_ads_subject)) ? $data->expiry_ads_subject : '' !!}" class="form-control" autocomplete="off" >
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Content:</label>
                                            <textarea class="form-control" id="expiry_ads" rows="5" placeholder="some details" > {!! (isset($data->expiry_ads_content)) ? $data->expiry_ads_content : '' !!}</textarea>
                                            <div class="expiry_ads">
                                                <a href="javascript:void(0)"> <span class="label label-success"> %name% </span> </a>
                                                <a href="javascript:void(0)"> <span class="label label-info"> %email% </span> </a>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button class=" pull-right btn w-md btn-bordered btn-success waves-effect waves-light" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{!! asset('assets/js/ckeditor/ckeditor.js') !!}"></script>
    <script>

        function replaceIt(e){
            $(e).val( $(e).val().replace(/ /g, "") );
        }

        $(document).ready(function() {
            // ck editor1
            CKEDITOR.replace('status_content',{
                allowedContent: true
            });
            // ck editor2
            CKEDITOR.replace('registration_content',{
                allowedContent: true
            });
            // verify_success
            CKEDITOR.replace('verify_success',{
                allowedContent: true
            });
            // verify_danger
            CKEDITOR.replace('verify_danger',{
                allowedContent: true
            });
             // verify_danger
            CKEDITOR.replace('expiry_ads',{
                allowedContent: true
            });

            // status tags add
            $('.status a').click(function(){
                var tag =  $(this).html();
                CKEDITOR.instances.status_content.insertHtml(tag);
            });
            // registration tags add
            $('.register a').click(function(){
                var tag =  $(this).html();
                CKEDITOR.instances.registration_content.insertHtml(tag);
            });
            // verify success add
            $('.verify_success a').click(function(){
                var tag =  $(this).html();
                CKEDITOR.instances.verify_success.insertHtml(tag);
            });
            // un verify success add
            $('.verify_danger a').click(function(){
                var tag =  $(this).html();
                CKEDITOR.instances.verify_danger.insertHtml(tag);
            });

            // un verify success add
            $('.expiry_ads a').click(function(){
                var tag =  $(this).html();
                CKEDITOR.instances.expiry_ads.insertHtml(tag);
            });


            // ajax submit form
            $("#email_settings").submit(function(){
                $('#loading').show();
                var data = new FormData(this);

                data.append('registration_content', CKEDITOR.instances.registration_content.getData());
                data.append('status_content', CKEDITOR.instances.status_content.getData());
                data.append('verify_success_content', CKEDITOR.instances.verify_success.getData());
                data.append('verify_danger_content', CKEDITOR.instances.verify_danger.getData());
                data.append('expiry_ads_content', CKEDITOR.instances.expiry_ads.getData());


                $.ajax({
                    url: "<?php  echo route('email-settings.store'); ?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(result){
                        $('#loading').hide();
                        if(result == '1'){
                            swal({
                                title: "Good job!",
                                text: "Email settings have been saved successfully!",
                                type: "success",
                                confirmButtonText: "OK"
                            });

                        }else{
                            swal("Error!", "Something went wrong.", "error");
                            $('#loading').hide();
                        }
                    }
                });

                return false;
            });

            // Email setting
            $("#EmailSettings").submit(function(){
                $('#loading').show();
                var data = new FormData(this);

                $.ajax({
                    url: "<?php  echo route('email-settings-store'); ?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(result){

                        if(result.success == 'success'){

                            $.post('{{ route('test-email') }}',
                                { '_token': '{{ csrf_token() }}', email: $('#test_email').val() },
                                function (data) {
                                    if(data.success == 'success') {
                                        swal({
                                            title: "Good job!",
                                            text: "Email settings have been saved successfully!",
                                            type: "success",
                                            confirmButtonText: "OK"
                                        });
                                        $('#loading').hide();
                                    }else{
                                        swal("Error!", data.error, "error");
                                        $('#loading').hide();
                                    }
                                });
                                $('#loading').hide();
                        }else{
                            swal("Error!", result.error, "error");
                            $('#loading').hide();
                        }

                    }
                });
                return false;
            });
        });
    </script>
@endsection
