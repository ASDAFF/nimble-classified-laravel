@extends('layouts.app')
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
                        <li> <a href="{{ url('/home') }}">Dashboard</a></li>
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
                                        <div class="col-md-12 m-t-20">
                                            <div class="form-group" >
                                                <label class="col-md-2  control-label">Timezone:</label>
                                                <div class="col-md-8" >
                                                    <select id="time-zone" name="time_zone" class="form-control" required >
                                                        <option value="Pacific/Tarawa" {{ ($user->time_zone == 'Pacific/Tarawa')? 'selected' :  '' }}>(GMT +12:00) Tarawa</option>
                                                        <option value="Pacific/Auckland" {{ ($user->time_zone == 'Pacific/Auckland')? 'selected' :  '' }}>(GMT +13:00) New Zealand Time</option>
                                                        <option value="Pacific/Norfolk" {{ ($user->time_zone == 'Pacific/Norfolk')? 'selected' :  '' }}>(GMT +11:30) Norfolk Island (Austl.)</option>
                                                        <option value="Pacific/Noumea" {{ ($user->time_zone == 'Pacific/Noumea')? 'selected' :  '' }}>(GMT +11:00) Noumea, New Caledonia</option>
                                                        <option value="Australia/Sydney" {{ ($user->time_zone == 'Australia/Sydney')? 'selected' :  '' }}>(GMT +11:00) Australian Eastern Time (Sydney)</option>
                                                        <option value="Australia/Brisbane" {{ ($user->time_zone == 'Australia/Brisbane')? 'selected' :  '' }}>(GMT +10:00) Australian Eastern Time (Queensland)</option>
                                                        <option value="Australia/Adelaide" {{ ($user->time_zone == 'Australia/Adelaide')? 'selected' :  '' }}>(GMT +10:30) Australian Central Time (Adelaide)</option>
                                                        <option value="Australia/Darwin" {{ ($user->time_zone == 'Australia/Darwin')? 'selected' :  '' }}>(GMT +9:30) Australian Central Time (Northern Territory)</option>
                                                        <option value="Asia/Tokyo" {{ ($user->time_zone == 'Asia/Tokyo')? 'selected' :  '' }}>(GMT +9:00) Tokyo</option>
                                                        <option value="Australia/Perth" {{ ($user->time_zone == 'Australia/Perth')? 'selected' :  '' }}>(GMT +8:00) Australian Western Time</option>
                                                        <option value="Asia/Hong_Kong" {{ ($user->time_zone == 'Asia/Hong_Kong')? 'selected' :  '' }}>(GMT +8:00) Hong Kong</option>
                                                        <option value="Asia/Bangkok" {{ ($user->time_zone == 'Asia/Bangkok')? 'selected' :  '' }}>(GMT +7:00) Thailand (Bangkok)</option>
                                                        <option value="Asia/Jakarta" {{ ($user->time_zone == 'Asia/Jakarta')? 'selected' :  '' }}>(GMT +7:00) Western Indonesian Time (Jakarta)</option>
                                                        <option value="Asia/Dhaka" {{ ($user->time_zone == 'Asia/Dhaka')? 'selected' :  '' }}>(GMT +6:00) Bangladesh (Dhaka)</option>
                                                        <option value="Asia/Kolkata" {{ ($user->time_zone == 'Asia/Kolkata')? 'selected' :  '' }}>(GMT +5:30) India</option>
                                                        <option value="Asia/Kabul" {{ ($user->time_zone == 'Asia/Kabul')? 'selected' :  '' }}>(GMT +4:30) Afghanistan (Kabul)</option>
                                                        <option value="Asia/Tashkent" {{ ($user->time_zone == 'Asia/Tashkent')? 'selected' :  '' }}>(GMT +5:00) Uzbekistan (Tashkent)</option>
                                                        <option value="Asia/Dubai" {{ ($user->time_zone == 'Asia/Dubai')? 'selected' :  '' }}>(GMT +4:00) UAE (Dubai)</option>
                                                        <option value="Europe/Moscow" {{ ($user->time_zone == 'Europe/Moscow')? 'selected' :  '' }}>(GMT +4:00) Moscow</option>
                                                        <option value="Asia/Tehran" {{ ($user->time_zone == 'Asia/Tehran')? 'selected' :  '' }}>(GMT +3:30) Tehran</option>
                                                        <option value="Africa/Djibouti" {{ ($user->time_zone == 'Africa/Djibouti')? 'selected' :  '' }}>(GMT +3:00) Djibouti</option>
                                                        <option value="Europe/Minsk" {{ ($user->time_zone == 'Europe/Minsk')? 'selected' :  '' }}>(GMT +3:00) Minsk</option>
                                                        <option value="Africa/Cairo" {{ ($user->time_zone == 'Africa/Cairo')? 'selected' :  '' }}>(GMT +2:00) Cairo</option>
                                                        <option value="Europe/Berlin" {{ ($user->time_zone == 'Europe/Berlin')? 'selected' :  '' }}>(GMT +1:00) European Time</option>
                                                        <option value="Europe/Lisbon" {{ ($user->time_zone == 'Europe/Lisbon')? 'selected' :  '' }}>(GMT 0:00) Lisbon</option>
                                                        <option value="Europe/London" {{ ($user->time_zone == 'Europe/London')? 'selected' :  '' }}>(GMT 0:00) British Time (London)</option>
                                                        <option value="Atlantic/Reykjavik" {{ ($user->time_zone == 'Atlantic/Reykjavik')? 'selected' :  '' }}>(GMT 0:00) Western European Time (Iceland)</option>
                                                        <option value="America/Danmarkshavn" {{ ($user->time_zone == 'America/Danmarkshavn')? 'selected' :  '' }}>(GMT -1:00) Eastern Greenland Time</option>
                                                        <option value="America/Sao_Paulo" {{ ($user->time_zone == 'America/Sao_Paulo')? 'selected' :  '' }}>(GMT -3:00) Eastern Brazil</option>
                                                        <option value="America/Godthab" {{ ($user->time_zone == 'America/Godthab')? 'selected' :  '' }}>(GMT -3:00) Central Greenland Time</option>
                                                        <option value="America/Thule" {{ ($user->time_zone == 'America/Thule')? 'selected' :  '' }}>(GMT -4:00) Western Greenland Time</option>
                                                        <option value="America/St_Johns" {{ ($user->time_zone == 'America/St_Johns')? 'selected' :  '' }}>(GMT -3:30) Newfoundland Time</option>
                                                        <option value="America/Argentina/Buenos_Aires" {{ ($user->time_zone == 'America/Argentina/Buenos_Aires')? 'selected' :  '' }}>(GMT -3:00) Buenos Aires</option>
                                                        <option value="Atlantic/Bermuda" {{ ($user->time_zone == 'Atlantic/Bermuda')? 'selected' :  '' }}>(GMT -4:00) Atlantic Time (Bermuda)</option>
                                                        <option value="America/Halifax" {{ ($user->time_zone == 'America/Halifax')? 'selected' :  '' }}>(GMT -4:00) Atlantic Time</option>
                                                        <option value="America/Caracas" {{ ($user->time_zone == 'America/Caracas')? 'selected' :  '' }}>(GMT -4:30) Venezuelan Standard Time</option>
                                                        <option value="America/New_York"  {{ ($user->time_zone == 'America/New_York')? 'selected' :  '' }}>(GMT -5:00) Eastern Time</option>
                                                        <option value="America/Chicago" {{ ($user->time_zone == 'America/Chicago')? 'selected' :  '' }}>(GMT -6:00) Central Time</option>
                                                        <option value="America/Monterrey" {{ ($user->time_zone == 'America/Monterrey')? 'selected' :  '' }}>(GMT -6:00) Central Time (Mexico City, Monterey)</option>
                                                        <option value="America/Regina" {{ ($user->time_zone == 'America/Regina')? 'selected' :  '' }}>(GMT -6:00) Central Time (Saskatchewan)</option>
                                                        <option value="America/Denver" {{ ($user->time_zone == 'America/Denver')? 'selected' :  '' }}>(GMT -7:00) Mountain Time</option>
                                                        <option value="America/Phoenix" {{ ($user->time_zone == 'America/Phoenix')? 'selected' :  '' }}>(GMT -7:00) Mountain Time (Arizona)</option>
                                                        <option value="America/Los_Angeles" {{ ($user->time_zone == 'America/Los_Angeles')? 'selected' :  '' }}>(GMT -8:00) Pacific Time</option>
                                                        <option value="America/Anchorage" {{ ($user->time_zone == 'America/Anchorage')? 'selected' :  '' }}>(GMT -9:00) Alaska Time</option>
                                                        <option value="Pacific/Honolulu" {{ ($user->time_zone == 'Pacific/Honolulu')? 'selected' :  ''}}>(GMT -10:00) Hawaiian/Aleutian Time</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Profile Image:</label>
                                            <div class="col-md-10">
                                                <img id="preview_profile" src="<?= ($user->image !="")? asset('assets/images/users/'.$user->image) : asset('assets/images/user_hidden.png') ?>" alt="" class="img-thumbnail">
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

        @include('partials.footer')
    </div>
    <!--  add category -->

    <script>

        $(document).ready(function() {
            // ajax submit form
            $("#profile_Setting").submit(function(){
              $('#loading').show();
                var data = new FormData(this);

                $.ajax({
                    url: "<?php  echo route('profile-settings'); ?>",
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
