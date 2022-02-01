@extends('layouts.app')
@section('content')
<?php $setting = DB::table('setting')->first();  ?>

<!-- signin-page -->
<section id="main" class="clearfix user-page">
    <div class="container">
        <div class="row text-center">
            <!-- user-login -->
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <div class="user-account">
                    <h2>User Login</h2>
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
                    <!-- form -->
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input id="email" type="email" class="form-control" name="email" @if (session('email')) value="{{ session('email') }}" @else  value="{{ old('email') }}" @endif  autofocus autocomplete="off">
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block text-left text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            <input id="password" type="password" class="form-control" name="password"  autocomplete="off">
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block text-left text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn">Login</button>
                    </form><!-- form -->

                    <!-- forgot-password -->
                    <div class="user-option">
                        <div class="checkbox pull-left">
                            <label for="logged"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="logged"> Keep me logged in </label>
                        </div>
                        <div class="pull-right forgot-password">
                            <a href="{{ route('password.request') }}">Forgot password</a>
                        </div>
                    </div><!-- forgot-password -->
                </div>
                <a href="{{ route('register') }}" class="btn-primary">Create a New Account</a>
            </div><!-- user-login -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- signin-page -->
@endsection
