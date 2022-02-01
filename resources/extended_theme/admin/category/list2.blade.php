@extends('admin.layout.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('admin_assets/css/custom.css') }}">
    <style>
        .add_more{float: right; margin-bottom: 5px; }
        .parent{
            background-color: #f2f2f2;
            padding: 5px;
            margin-bottom: 5px;
        }
        .parent .parent{
            background-color: #f7d8af;
            padding: 5px;
            margin-bottom: 5px;
        }
        .parent .parent .parent{
            background-color: bisque;
            padding: 5px;
            margin-bottom: 5px;
        }
        .no_child{
            background-color: #e2e2e2;
            margin-bottom: 5px;
        }
        ul{
            list-style: none;
        }
        li{
            padding: 5px 10px 3px 2px;
        }
    </style>
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="col-xs-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li> <a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="active"> Category </li>
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

                    <div class="col-xs-12 bg-white product-listing ">
                        <!--   LIST       -->
                        <?= buildCategory(0, $category) ?>

                        <!-- End list  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--  add user -->
    <div id="catModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                    <h4 class="modal-title">Add/Edit User</h4>
                </div>
                <form id="add_category" method="post" role="form" >
                    <input type="hidden" name="id" value="" id="id" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Title:</label>
                                    <input type="text" name="title" class="form-control" value="" id="name" placeholder="Category title" required >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Category:</label>
                                    <select name="category" id="" class="form-control">
                                        <option value="0">Parent category</option>
                                        @foreach($cat as $value){
                                            <option value="{{  $value['category_id'] }}"> {{ $value['category_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
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

function buildCategory($parent, $category) {
        $html = '';
        if (isset($category['parent_cats'][$parent])) {
    $html .= "<ul class=''>";
        foreach ($category['parent_cats'][$parent] as $cat_id) {

            if (!isset($category['parent_cats'][$cat_id])) {
            $html .= "<li class='no_child'>

                <label for='cat_{$cat_id}'>
                    <input type='checkbox' id='cat_{$cat_id}' class='childCheckBox'> " . $category['categories'][$cat_id]['category_name'] . "</a>
                </label>

                </li> ";
            }
            if (isset($category['parent_cats'][$cat_id])) {
            $html .= "<fieldset class='set'><li class='parent'>

                <label for='cat_{$cat_id}'>
                <input onchange='fnTest(this);' type='checkbox' id='cat_{$cat_id}' class='parentCheckBox'> " . $category['categories'][$cat_id]['category_name'] . "
                 </label>
                 ";
                $html .= buildCategory($cat_id, $category);
                $html .= "</li></fieldset> ";
            }
        }
        $html .= "</ul> ";
    }
    return $html;
    }
?>
    <script>

        function addCategory(){
            $("#catModal").modal('show');
        }

        $(document).ready(function(){
            // category
            function fnTest(check) {
                $(check).closest("ul").find(":checkbox").prop("checked",check.checked);


//            $('.set').on('click', ".parent", function () {
//                var $checkboxes = $(this).children("[type=checkbox]");
//                var isChecked = $checkboxes.prop("checked");
//                $checkboxes.prop("checked", !isChecked);
//            });






            //clicking the parent checkbox should check or uncheck all child checkboxes
//            $(".parentCheckBox").click(
//                    function() {
//                        $(this).parents('fieldset:eq(0)').find('.childCheckBox').prop('checked', this.checked);
//                        //$(this).parents('fieldset:eq(0)').find('ul').toggle();
//                    }
//            );
            //clicking the last unchecked or checked checkbox should check or uncheck the parent checkbox
            //saving new user
            $("#add_category").submit(function(){
                $('#loading').show();
                var data = new FormData(this);
                $.ajax({
                    url: "<?php echo route('category.store'); ?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(result){
                        $('#loading').hide();

                        if(result =='1'){
                            swal("Success!", "Category added successfully.", "success");
                        }else{
                            swal("Error!", "Something went wrong.", "error");
                        }
                    }
                });
                return false;
            });
        });

    </script>

@endsection
