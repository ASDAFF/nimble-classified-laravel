@extends('admin.layout.app')
@section('title', 'Categories')
@section('content')
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
                        <li class="active"> Profile Settings </li>
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
                                    <h3 class="panel-title">Profile Settings</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" id="profile_Setting" >
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ (isset($data->id) && $data->id != "")? $data->id :''  }}">
                                        <input type="hidden" name="id">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Name:</label>
                                            <div class="col-md-10">
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"  placeholder=""  required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2  control-label">Email:</label>
                                            <div class="col-md-10">
                                                <input type="email" readonly disabled class="form-control" value="{{ $user->email }}" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Password:</label>
                                            <div class="col-md-10">
                                                <input type="text" name="password" class="form-control" value="{{ $user->plain_password }}"  placeholder=""  required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Profile Image:</label>
                                            <div class="col-md-10">
                                                <img id="preview_profile" src="<?= ($user->image !="")? asset('assets/images/users/'.$user->image.' ') : asset('admin_assets/images/user_hidden.png') ?>" alt="" class="img-thumbnail img-responsive">
                                                <input type="file" name="image" class="form-control file_hidden">
                                                <button id="browse_profile" class="btn w-md btn-bordered btn-success waves-effect waves-ligh " type="button">Browse</button>
                                            </div>
                                        </div>
                                        <div class="form-group account-btn m-t-10">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-xs-10">
                                                <button class="btn w-md btn-bordered btn-info waves-effect waves-light pull-right" type="submit">Submit</button>
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
    <!--  add category -->
    <script>
        $(document).ready(function() {
            // ajax submit form
            $("#profile_Setting").submit(function(){
              $('#loading').show();
                var data = new FormData(this);
                $.ajax({
                    url: "<?php  echo url('profile-settings'); ?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(result){
                        if(result.msg == 2){
                            // error
                            swal("Error!", result.error[0], "error");
                            $('#loading').hide();
                        }else if(result.msg == 1){
                            // success
                            $('#loading').hide();
                            var user_name =  $('input[name="name"]').val();
                            $('#user_name, .user-info a').text(user_name);
                            $('.profile-img').attr('src','<?= asset('assets/images/users') ?>/' + result.file_name);
                            // swal("Good job!", "Subject has been saved successfully.", "success")
                            swal({
                                title: "Good job!",
                                text: "Profile has been saved successfully!",
                                type: "success",
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
                return false;
            });
            // browse image
            $('#browse_profile').click( function(){
                $('.file_hidden').click();
            });
            // profile preview
            function readURL(input, id) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#'+id).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".file_hidden").change(function() {
                readURL(this, 'preview_profile');
            });
        });
    </script>
@endsection
