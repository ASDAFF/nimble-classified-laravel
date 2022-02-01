@extends('layouts.app')
@section('content')
    <style>
        #type{
            padding-left: 32px;
        }
        hr{
            margin: 0;
        }
        .form-group {
            margin-bottom: 0;
        }
        #password-confirm{
            margin-bottom: 10px;
        }
        .b-registration-info-container{
            height: 602px;
        }
         .b-registration-info-container .b-registration-info-title {
             font-size: 20px;
             margin-bottom: 15px;
             color: #1f1f1f;
         }
        .b-registration-info-container .b-registration-info-text {
            font-size: 15px;
        }
        .b-rounded-list {
            list-style-type: none;
            margin: 50px 0 25px -10px;
            font-size: 13px;
        }
        .b-rounded-list li {
            float: left;
            width: 100%;
            border: 0;
            vertical-align: baseline;
            margin: 0;
            padding: 0;
        }
        .b-rounded-list li .b-rounded-list-pointer {
            float: left;
        }
        .b-rounded-list {
            list-style-type: none;
            margin: 50px 0 25px -10px;
            font-size: 13px;
        }
        .b-rounded-list li .b-rounded-list-pointer span {
            font-size: 22px;
            font-weight: bold;
            color: #000;
            height: 60px;
            width: 60px;
            border-radius: 100%;
            border: 5px solid #d9d9d9;
            background: #fff;
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .b-rounded-list li .b-rounded-list-content {
            padding: 10px 0 20px 40px;
            border-left: 2px solid #ccc;
            margin-left: 27px;
        }
        .b-rounded-list li {
            float: left;
            width: 100%;
        }
        .border-rad{
            border-top: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            border-color: #dddddd;
            border-bottom-right-radius: 4px ;
            border-top-right-radius: 4px ;
        }
    </style>
<?php  $setting = DB::table('setting')->first(); ?>
<div class="container m-t-30">
    <div class="row">
        <div class="row col-md-6 col-md-offset-1">
            <div class="panel panel-default">
                <div class="text-center">
                    <h2 class="logo-title">
                        <span class="logo-icon"><img src="{{asset('assets/images/logo/'.$setting->logo)}}" alt="" height="60"> </span>
                    </h2>
                </div>
                <hr>
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
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="name" class="control-label">Username:</label>
                                <div class="input-icon"><i class="icon-user fa"></i>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus autocomplete="off">
                                </div>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="email" class="control-label">E-Mail Address:</label>
                                <div class="input-icon"><i class="icon-mail fa"></i>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="off">
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!--<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="phone" class="control-label">Phone:</label>
                                <div class="input-icon"><i class="icon-phone fa"></i>
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autocomplete="off">
                                </div>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="type" class="control-label">User Type:</label>
                                <div class="input-icon"><i class="icon-users fa"></i>
                                    <select id="type" type="type" class="form-control" name="type" value="{{ old('type') }}" required autocomplete="off">
                                        <option value="">Select user type</option>
                                        <option {{ (old('type') == 'u')? 'selected' : '' }} value="u">Private user</option>
                                        <option {{ (old('type') == 'c')? 'selected' : '' }} value="c">Company</option>
                                    </select>
                                </div>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}" style="margin-bottom: -15px">
                            <div class="col-md-12">
                                <label for="gender" class="control-label">Gender:</label><br>
                                <label for="male">
                                    <input id="male" type="radio" name="gender" value="m" {{ (old('gender') == 'm')? 'checked' : '' }} required>
                                    Male
                                </label>
                                <label for="female">
                                    <input id="female" type="radio"  name="gender" value="f" {{ (old('gender') == 'f')? 'checked' : '' }}  required>
                                    Female
                                </label>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="password" class="control-label">Password:</label>
                                <div class="input-icon"><i class="icon-lock fa"></i>
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="off">
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="password-confirm" class="control-label">Confirm Password:</label>
                                <div class="input-icon"><i class="icon-check fa"></i>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                                <a class="pull-right" href="{{route('login')}}"> Already member? </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class=" col-md-4 bg-white p-20">
            <!-- Start -->
            <div class="b-registration-info-container">
                <div class="b-registration-info">
                    <div class="b-registration-info-title"> The advantages of registering </div>
                    <div class="b-registration-info-text">
                        {{ $setting->title }} is the free service, designed to manage your ads in an easy and immediate way.
                        <ul class="b-rounded-list">
                            <li>
                                <div class="b-rounded-list-pointer">
                                    <span>1</span>
                                </div>
                                 <div class="b-rounded-list-content">
                                    <div class="font-weight-bold">Rapidity</div>
                                    <p>Publish your adverts without waiting for notification by e-mail</p>
                                </div>
                            </li>
                            <li>
                                <div class="b-rounded-list-pointer">
                                    <span>2</span>
                                </div>
                                <div class="b-rounded-list-content">
                                    <div class="font-weight-bold">Statistics</div>
                                    <p>Analyze ad performance, number of visits and responses</p>
                                </div>
                            </li>
                            <li class="b-last">
                                <div class="b-rounded-list-pointer">
                                    <span>3</span>
                                </div>
                                <div class="b-rounded-list-content">
                                    <div class="font-weight-bold">Visibility</div>
                                    <p>Promote your ads by purchasing the Credit Packages</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function () {
            var Height = $('.panel-default').height();
            console.log(Height);
        })
    </script>
@endsection
