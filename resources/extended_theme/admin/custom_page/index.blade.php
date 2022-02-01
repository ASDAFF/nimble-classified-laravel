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
                        <li class="active"> Custom Page </li>
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
                                <h3 class="panel-title">Custom Page</h3>
                            </div>
                            <div class="panel-body">

                                <form action="" method="post" id="customForm" autocomplete="off">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ isset($page->id) ? $page->id : '' }}" name="id">
                                    <div class="form-group">
                                        <label for=""> Page Title </label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ isset($page->title) ? $page->title : '' }}" requireD />
                                    </div>

                                    <div class="form-group">
                                        <label for=""> Page Content </label>
                                        <textarea class="form-control" id="content" required >{!! isset($page->contents) ? $page->contents : '' !!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success"> Submit </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="{!! asset('assets/js/ckeditor/ckeditor.js') !!}"></script>
    <script>

        $(document).on('keypress', '#title', function (event) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });

        $(document).ready(function(){

            // ck editor1
            var editor = CKEDITOR.replace('content',{
                allowedContent: true,
            });

            // ajax submit form
            $("#customForm").submit(function(){
                $('#loading').show();
                var data = new FormData(this);
                data.append('contents', CKEDITOR.instances.content.getData());

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

                            @if (!isset($page->id))
                                CKEDITOR.instances.content.setData('');
                                $("#customForm")[0].reset();
                            @endif

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
