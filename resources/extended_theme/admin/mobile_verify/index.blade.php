@extends('admin.layout.app')
@section('content')

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
                                <li class="active"> Mobile verification  Settings</li>
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
                                <h3 class="panel-title">Mobile verification  Settings</h3>
                            </div>
                            <div class="panel-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#twilio_settings" data-toggle="tab" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-home"></i></span>
                                            <span class="hidden-xs">Twilio Settings</span>
                                        </a>
                                    </li>

                                    @if(isset($mobile_verify))
                                        <li class="">
                                            <a href="#twilio_number" data-toggle="tab" aria-expanded="false">
                                                <span class="visible-xs"><i class="fa fa-home"></i></span>
                                                <span class="hidden-xs">Twilio Number</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="twilio_settings">
                                        <form method="post" action="{{ route('mobile_verify.store') }}" id="MobileSettings">
                                            <input type="hidden" name="id" id="Id" value="{{ isset($mobile_verify)&& $mobile_verify->id ==1 ? $mobile_verify->id : '' }}">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <lable>Sid</lable>
                                                <input type="text" name="twilio_sid" value="{{ isset($mobile_verify)&& $mobile_verify->twilio_sid !='' ? $mobile_verify->twilio_sid : '' }}" class="form-control" placeholder="Enter your twilio sid" required >
                                            </div>
                                            <div class="form-group">
                                                <lable>Token</lable>
                                                <input type="text" name="twilio_token" value="{{ isset($mobile_verify)&& $mobile_verify->twilio_token !='' ? $mobile_verify->twilio_token : '' }}" class="form-control" placeholder="Enter your twilio token" required >
                                            </div>
                                            @if(isset($mobile_verify))
                                                <?php
                                                    if (isset($response['RestException'])) {
                                                        echo '<span class="text-danger">'.$response['RestException']->Detail.'</span><br>';
                                                    }
                                                ?>
                                            @endif
                                            <br>
                                            <div class="form-group">
                                                <button class="btn btn-success btn-sm">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    @if(isset($mobile_verify))
                                    <div class="tab-pane" id="twilio_number">
                                        <form id="twilio_number" method="post" {{ route('mobile_verify.store') }}>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="Id" value="{{ isset($mobile_verify)&& $mobile_verify->id ==1 ? $mobile_verify->id : '' }}">
                                            <div class="form-group">
                                                <label >Twilio number</label>
                                                <select name="twilio_number" id="twilio_phone" class="form-control" required>
                                                    <option value="asdfafd">Select number</option>
                                                <?php
                                                if (isset($response['IncomingPhoneNumbers']->IncomingPhoneNumber)) {
                                                    foreach ($response['IncomingPhoneNumbers']->IncomingPhoneNumber as $numberResponse) {
                                                    ?>
                                                    <option {{ isset($mobile_verify)&& $mobile_verify->twilio_number == $numberResponse->PhoneNumber ? 'selected' : '' }}  value="<?= $numberResponse->PhoneNumber ?>"><?= $numberResponse->PhoneNumber ?> </option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-success btn-sm">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                </div>
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
            });
        </script>
@endsection