@extends('layouts.app')
@section('content')

<div class="main-container m-t-30">
    <div class="container">
        <div class="row">
           <div class="col-md-6 col-md-offset-4 login-box">
                <div class="panel panel-default" style="background-color: #f5f5f5">
                    <div class="text-center">
                        <h2 class="logo-title m-t-20"> Contact Us Form </h2>
                    </div>
                    <hr>
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
                    <div class="panel-body">
                <form action="{{ route('save-contact-form') }}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="">First Name</label>
                <input type="text" class="form-control" requireds value="{{ old('first_name') }}" name="first_name">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Last Name</label>
                <input type="text" class="form-control" requireds name="last_name" value="{{ old('last_name') }}">
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" requireds name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Subject</label>
                <input type="text" class="form-control" requireds name="subject" value="{{ old('subject') }}">
                @if ($errors->has('subject'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('subject') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Message</label>

                <textarea class="form-control" requireds name="message">{{ old('message') }}</textarea>
                @if ($errors->has('message'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('message') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-danger btn-lg" onclick="$('.fa-spinner').removeClass('hidden')"><i class="fa fa-send"></i> Send <i class="fa fa-spinner fa-spin hidden"></i> </button>
            </div>
        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection