@extends('admin.layout.app')
@section('content')
<!-- HOME -->
<section>
    <div class="container-alt">
        <div class="row">
            <div class="col-sm-12">
                <div class="wrapper-page">
                    <div class="m-t-40 account-pages">
                        <div class="text-center account-logo-box">
                            <h2 class="text-uppercase">
                                <a href="index.html" class="text-success">
                                    <span>Admin Login</span>
                                </a>
                            </h2>
                            <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                        </div>
                        <div class="account-content">
                            <form class="form-horizontal" method="POST" action="{{ route('admin-login.store') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="text" placeholder="Username" name="email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-xs-12">
                                        <input class="form-control" type="password" placeholder="Password" name="password" value="{{ old('password') }}">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="col-xs-12">
                                        <div class="checkbox checkbox-success">
                                            <input id="checkbox-signup" name="remember"  {{ old('remember') ? 'checked' : '' }} type="checkbox">
                                            <label for="checkbox-signup">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group account-btn text-center m-t-10">
                                    <div class="col-xs-12">
                                        <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- end wrapper -->
            </div>
        </div>
    </div>
</section>
<!-- END HOME -->
@endsection