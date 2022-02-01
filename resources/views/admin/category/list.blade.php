@extends('admin.layout.app')@section('content')
    <link rel="stylesheet" href="{{ asset('admin_assets/css/custom.css') }}">
    <style>
        .add_more {
            float: right;
            margin-bottom: 5px;
        }
        .parent {
            background-color: #ff4949;
            padding: 5px;
            margin-bottom: 5px;
            color: #fff;
        }
        .parent .parent {
            background-color: #ff7d7d;
            padding: 5px;
            margin-bottom: 5px;
        }
        .parent .parent .parent {
            background-color: #ffc7c7;
            padding: 5px;
            margin-bottom: 5px;
            color: black;
        }
        .no_child {
            background-color: #e9e9e9;
            margin-bottom: 5px;
            color: black;
            border: 1px solid #a7a7a7;
            padding-left: 10px;
        }
        ul {
            list-style: none;
        }

        li {
            padding: 5px 10px 3px 2px;
        }    </style>
    <div class="content-page">        <!-- Start content -->
        <div class="content">
            <div class="col-xs-12">
                <div class="page-title-box"><h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="active"> Category List</li>
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
                <div class="card-box">
                    <div class="row">
                        <div class="btn-group pull-right m-b-10">
                            <button type="button" class="btn btn-primary waves-effect waves-light  dropdown-toggle"
                                    data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li onclick="$('#catForm').submit()"><a href="javascript:void(0);"><i
                                                class="fa fa-trash" aria-hidden="true"></i> Delete Item </a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 bg-white product-listing "><!--   LIST       -->
                            <form id="catForm">
                                <?= buildCategory(0, $category) ?>
                            </form>
                            <!-- End list  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!--  add user -->
    <div id="catModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                    <h4 class="modal-title">Add/Edit User</h4></div>
                <form id="add_category" method="post" role="form"><input type="hidden" name="id" value="" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"><label for="">Title:</label> <input type="text" name="title"
                                                                                            class="form-control"
                                                                                            value="" id="name"
                                                                                            placeholder="Category title"
                                                                                            required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"><label for="">Category:</label> <select name="category" id=""
                                                                                                class="form-control">
                                        <option value="0">Parent category</option> @foreach($cat as $value){
                                        <option value="{{  $value['id'] }}"> {{ $value['name'] }}</option>                                        @endforeach
                                    </select></div>
                            </div>
                        </div>
                        <div class="col-md-12" id="c_info"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    function buildCategory($parent, $category)
    {
        $html = $icon = '';
        if (isset($category['parent_cats'][$parent])) {
            $html .= "<ul class=''>";
            foreach ($category['parent_cats'][$parent] as $cat_id) {

                   if ($category['categories'][$cat_id]['icon'] != '') {
                        $icon = ' <i class="' . $category['categories'][$cat_id]['icon'] . '"></i> ';
                    }
                    if ($category['categories'][$cat_id]['image'] != '') {
                        $icon = '<img src="'.asset('assets/images/c_icons/'.$category['categories'][$cat_id]['image']).'" height="20px">';
                    }

                if (!isset($category['parent_cats'][$cat_id])) {
                    $html .= "<li class='no_child'>

                    <div class='pull-right'>
                    <a href='".route('category.edit', $cat_id)."' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a>
                    </div>
                <label for='cat_{$cat_id}'> <input type='checkbox' id='cat_{$cat_id}' name='cat_id[]' value='" . $category['categories'][$cat_id]['id'] . "' class='childCheckBox'> " . $icon . $category['categories'][$cat_id]['name'] . "</a>
                    </label>
                    </li> ";
                }
                if (isset($category['parent_cats'][$cat_id])) {
                    $html .= "<fieldset>
                    <li class='parent'>
                    <div class='pull-right'>
                    <a href='".route('category.edit', $cat_id)."' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a>
                    </div>
                        <label for='cat_{$cat_id}'>
                            <input  type='checkbox' name='cat_id[]' value='" . $category['categories'][$cat_id]['id'] . "' id='cat_{$cat_id}' class='parentCheckBox'> " . $icon . $category['categories'][$cat_id]['name'] . "
                                            </label>                 ";
                    $html .= buildCategory($cat_id, $category);
                    $html .= "</li></fieldset> ";
                }
            }
            $html .= "</ul> ";
        }
        return $html;
    }    ?>
    <script>
        $(document).ready(function () {
            $('#catForm').submit(function () {
                var data = new FormData(this);
                if ($('#catForm input:checked').length < 1) {
                    swal('Alert!', 'Please select category to proceed!', 'warning');
                } else {
                    swal({
                        title: "Are you sure?",
                        text: "You cannot recover it later.",
                        type: "error",
                        showCancelButton: true,
                        cancelButtonClass: 'btn-default btn-md waves-effect',
                        confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                        confirmButtonText: 'Confrim!'
                    }, function (isConfirm) {
                        if (isConfirm) {
                            $("#loading").show();
                            $.ajax({
                                url: "<?php echo url('delete-category'); ?>",
                                data: data,
                                contentType: false,
                                processData: false,
                                type: 'POST',
                                success: function (result) {
                                    if (result == 1) {
                                        swal("Success!", "Category deleted successfully.", "success");
                                        window.location.href='{{ route('category.index') }}';
                                    } else {
                                        swal("Error!", 'Something went wrong!', "error");
                                    }
                                }
                            });
                        }
                    });
                }
                return false;
            });
            $(".parentCheckBox").click(function () {
                $(this).parents('fieldset:eq(0)').find('.childCheckBox').prop('checked', this.checked);
            });
        });
    </script>
@endsection