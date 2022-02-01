@extends('admin.layout.app')
@section('content')
    <style>
        #sortable li:hover{
            cursor: all-scroll;
        }
    </style>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li> <a href="{{ url('/home') }}">Dashboard</a></li>
                        <li class="active"> Manage Custom Page </li>
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
                                <h3 class="panel-title">Manage Custom Page</h3>
                            </div>
                            <div class="panel-body">
                                <ul id="sortable" class="list-group">
                                    @if(count($page) > 0)
                                        @foreach($page as $value)
                                            <li class="list-group-item" id="{{$value->id}}">
                                                <i class="fa fa-sort"></i> &nbsp;
                                                {{ $value->title }}
                                                <button data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger pull-right" onclick="deleteRow(this)" data-id="{{$value->id}}" data-obj="custom_page"> <i class="fa fa-trash"></i> </button>
                                                <a href="{{route('custom-page.edit', $value->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary pull-right m-r-5"> <i class="fa fa-pencil"></i> </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{!! asset('assets/js/ckeditor/ckeditor.js') !!}"></script>
    <script>

        $(document).ready(function() {

            $( function() {
                $( "#sortable" ).sortable({

                    stop: function(event, ui) {
                        var itemOrder = $('#sortable').sortable("toArray");
                        $.get('{{route('sort-pages')}}', {itemOrder:itemOrder}, function (data) {
                        })
                    }
                });

            });

            // ajax submit form
            $("#customForm").submit(function(){
                $('#loading').show();
                var data = new FormData(this);
                data.append('content', CKEDITOR.instances.content.getData());

                $.ajax({
                    url: "<?php  echo route('custom-page.store'); ?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(result){
                        $('#loading').hide();
                        if(result.msg == 1){
                            swal({
                                title: "Good job!",
                                text: "Page have been saved successfully!",
                                type: "success",
                                confirmButtonText: "OK"
                            });
                            CKEDITOR.instances.content.setData('');
                            $("#customForm")[0].reset();

                        }else if(result.msg == 3){
                            swal("Error!", "page with same title already exists", "error");
                        }else{
                            swal("Error!", "Something went wrong.", "error");
                            $('#loading').hide();
                        }
                    }
                });
                return false;
            });
        });
    </script>
@endsection
