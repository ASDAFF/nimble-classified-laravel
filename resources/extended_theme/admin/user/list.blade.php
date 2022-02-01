@extends('admin.layout.app')
@section('content')
<style>
    .add_more{float: right; margin-bottom: 5px;
    }
</style><div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="col-xs-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb p-0 m-0">
                    <li> <a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="active"> Users </li>
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
                    <div class="add_more">
                        <button type="button" class="btn btn-success waves-effect w-md waves-light" onclick='addUser()' >Create User</button>
                    </div>
                    <div class="col-xs-12 bg-white">
                        <table id="load_datatable" class="table table-colored table-inverse table-hover table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Dated</th>
                                <th>Status&nbsp;|&nbsp;Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="4">No Record found yet.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  add user -->
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                <h4 class="modal-title">Add/Edit User</h4>
            </div>
            <form id="add_user" method="post" role="form" >
                <input type="hidden" name="id" value="" id="id" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Name:</label>
                                <input type="text" name="name" class="form-control" value="" id="name" placeholder="name" required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Email:</label>
                                <input type="email" name="email"  class="form-control" value="" id="email" placeholder="valid email" required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Password:</label>
                                <input type="text" name="password"  class="form-control" value="" id="plain_password" placeholder="password" required >
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

<!-- Modal verification-->
<div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modelTitleId">Verify User</h4>
            </div>
            <div class="modal-body">
                <center>
                    <!-- Ajax content here -->
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="checkIsVfy(this)" value="" id="ok" class="btn btn-primary">Verified</button>
                <button type="button" onclick="checkIsVfy(this)" value=""  id="err" class="btn btn-danger">Unverified</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        //saving new user
        $("#add_user").submit(function(){
            $('#loading').show();
            var data = new FormData(this);
            $.ajax({
                url: "<?php echo route('users.store'); ?>",
                data: data,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(result){
                    $('#loading').hide();
                    var json_obj = JSON.parse(result);
                    if(json_obj.msg!='0'){

                        if(json_obj.msg =='email'){
                            $('#email').focus();
                            swal("Error!", 'Email already taken!' , "error");
                        }
                        if(json_obj.msg=='1'){
                            $('#add_user')[0].reset();
                            $("#id").val("");
                            $("#con-close-modal").modal('hide');
                            refreshTable();
                            swal("Success!", "User has been saved successfully", "success");
                        }
                    }else{
                        swal("Error!", "Something went wrong.", "error");
                    }
                }
            });
            return false;
        });

        $('#load_datatable').DataTable({
            "pageLength":25,
            "order": [[0, 'desc']],
            processing: true,
            serverSide: true,
            "initComplete": function (settings, json) {
            },
            ajax: "{!! Route('load-users') !!}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
                //{ data: 'updated_at', name: 'updated_at' }
            ]
        });
    });

    function checkIsVfy(e){

        var id = $(e).val();
        var status = $(e).attr('id');
        if(id !='' && status !=''){
            $('#loading').show();

            if(status == 'ok'){ status = 2; }
            if(status == 'err'){ status = 3; }
            $.get("{{ url('vfy-card') }}", {id: id, status: status}, function(result){
                if(result == '1'){
                    refreshTable();
                    $("#cardModal").modal('hide');
                    swal("Success!", "operation successful!", "success");
                }else{
                    swal("Error!", "Something went wrong.", "error");
                }
                $('#loading').hide();
                })
        }
    }
    function view_card(id){
        $('#loading').show();
        if(id!=''){

            $.get("{{ url('show-card') }}", {id: id}, function(result){
                if(result!='0'){
                    $('#cardModal .modal-body center').html('');
                    $('#cardModal .btn').val(id);
                    var res = result.split(",");

                    for( var i = 0; i < res.length; i++ ){

                        $('#cardModal .modal-body center').append('<img src="{{asset('assets/images/users/id_card')}}' +'/'+ res[i]+ '" class="img-responsive" /><hr>' );
                    }
                        $("#cardModal").modal('show');
                    //console.log(cat_array_length);
                }else{
                    swal("Error!", "Something went wrong.", "error");
                }
                $('#loading').hide();
            }
            );
		}
	}
    function addUser(){
        $("#con-close-modal").modal('show');
    }
    function editRow(x){
        $('#loading').show();
        if(x!=''){
            $.post("<?php echo url('user/loadEdit'); ?>", {id: x}, function(result){
                        if(result!='0'){
                            var data = JSON.parse(result);
                            $.each(data, function(k,v){
                                var ref = $("#add_user").find("#"+k);
                                $(ref).val(v);
                                $("#con-close-modal").modal('show');
                            });
                            //console.log(cat_array_length);
                        }else{
                            swal("Error!", "Something went wrong.", "error");
                        }
                        $('#loading').hide();
                    }
            );
        }
		}
    // make frivate

    function changestatus(e){
        $('#loading').show();
        var id = $(e).data('id');
        var action = 'imported';
        $.post( '{{ url('user-status') }}',
            {id:id, action:action},
            function(data){
                var obj = $.parseJSON(data);
                if(obj.res == 0){
                    refreshTable();
                    swal('Success', 'User Unblocked successfully!' , 'success');
                }
                if(obj.res == 1){
                    swal('Success', 'User blocked successfully!' , 'success');
                    refreshTable();
                }
                $('#loading').hide();
            });
    }
</script>
@endsection
