@extends('layouts.app')
@section('content')

<div class="main-container m-t-30">
    <div class="container">
        <div class="row">
           <div class="col-md-12">
               <h2 class="page-title">{{$page->title}}</h2>
               <hr>
                {!! $page->contents !!}
            </div>
        </div>
    </div>
</div>

@endsection