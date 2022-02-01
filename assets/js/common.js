$(document).ready(function () {
// save ad
    $('.save-add').click(function () {

        var ev = $(this);
        console.log(ev.attr('data-action'));
        ev.find('.fa-spinner').removeClass('hidden');

        var ad_id = ev.attr('data-id');
        var action = ev.attr('data-action');

        $.get(base_url+'/save-add', {id:ad_id, action:action}, function(data){
            if(data!=''){
                ev.find('.fa-spinner').addClass('hidden');

                if(action == 'ins') {
                    ev.attr('data-action', 'del');
                    ev.find('.text').html('Add Saved');
                    ev.find('.fa').removeClass('fa-star-o').addClass('fa-star');
                }else{
                    ev.attr('data-action', 'ins');
                    ev.find('.text').html('Save Add');
                    ev.find('.fa').addClass('fa-star-o').removeClass('fa-star');
                }

            }
        });
        //return false;
    });


    //Auto Close Timer
    $('.sync_contacts').on('change', function () {

        $('#loading').show();

        if ($('.sync_contacts').is(':checked')) {
            var sync = 1;
            var message = 'Your contacts synchronize enabled successfully!';
        } else {
            var sync = 0;
            var message = 'Your contacts synchronize disabled successfully!';
        }
        var link = base_url + '/sync_stats';

        $.post(link, {sync: sync}, function (result) {
            $('#loading').show();
            if (result == 1) {
                swal('Success!', message, 'success');
            }
            $('#loading').hide();
        });


        //var intv = setInterval(function(){
        //    $('#loading').hide();
        //    swal('Success!', 'Your contacts synchronized successfully. ', 'success' );
        //    clearInterval(intv);
        //}, 5000);

    });

});


function refreshTable() {
    $('#load_datatable').DataTable().ajax.reload();
}

// inactive ad
function inactive_ad(e){
    var id = $(x).data('id');
    if (id!='') {

        swal({
                title: "Are you sure?",
                text: "You cannot recover it later.",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Confirm!'
            },
            function (isConfirm) {
                if (isConfirm) {
                    $("#loading").show();

                    $.post(link, {id: id, obj: obj}, function (result) {
                            //console.log(result);

                            // delete image gallery check to prevent error
                            if (obj != 'gallery') {
                                refreshTable();
                            }
                            if (result != '0') {
                                var data = JSON.parse(result);
                                if (data.type == 'success') {
                                    //hide gallery image
                                    if (obj == 'gallery') {
                                        $('#item_' + id).hide();
                                    }
                                    swal("Success!", data.msg, "success");
                                    if (obj == 'groups' || obj == 'group_fields' || obj == 'smtp_settings' || obj == 'sparkpost_settings' || obj == 'sendgrid_settings' || obj == 'activecampaign_settings' || obj == 'aweber_settings' || obj == 'getresponse_settings' || obj == 'mailchimp_settings') {
                                        location.reload();
                                    }
                                }
                                if (data.type == 'error') {
                                    swal("Error!", data.msg, "error");
                                }

                            } else {
                                swal("Error!", "Something went wrong.", "error");
                            }
                            $('#loading').hide();
                        }
                    );

                } else {
                    swal("Cancelled", "Your action has been cancelled!", "error");
                }
            }
        );

    } else {
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}


// delete record
function deleteRow(x) {

    var id = $(x).data('id');
    var obj = $(x).data('obj');
    var link = $("#delete_link").val();

    if (id != '' && obj != '') {
        swal({
                title: "Are you sure?",
                text: "You cannot recover it later.",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-default btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Confirm!'
            },
            function (isConfirm) {
                if (isConfirm) {
                    $("#loading").show();
                    $.post(link, {id: id, obj: obj}, function (result) {
                            //console.log(result);
                            // delete image gallery check to prevent error
                            if (obj != 'gallery') {
                                refreshTable();
                            }
                            if (obj == 'custom_page'){
                                $(x).parent().hide();
                            }
                            if (result != '0') {
                                var data = JSON.parse(result);
                                if (data.type == 'success') {
                                    //hide gallery image
                                    if (obj == 'gallery') {
                                        $('#item_' + id).hide();
                                    }
                                    swal("Success!", data.msg, "success");
                                    if (obj == 'groups' || obj == 'group_fields' || obj == 'chat') {
                                        location.reload();
                                    }
                                }
                                if (data.type == 'error') {
                                    swal("Error!", data.msg, "error");
                                }

                            } else {
                                swal("Error!", "Something went wrong.", "error");
                            }
                            $('#loading').hide();
                        }
                    );

                } else {
                    swal("Cancelled", "Your action has been cancelled!", "error");
                }
            }
        );

    } else {
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}


function changeStatus(e) {

    //$('#loading').show();
    var id = $(e).data('id');
    var obj = $(e).data('obj');
    var link = base_url + '/change-status';

    if (id != '' && obj != '') {
        $.post(link, {id: id, obj: obj}, function (result) {
                //$('#loading').hide();
                refreshTable();

            if(obj == 'user_ads'){
                var OBJ = $.parseJSON(result);
                console.log(OBJ);
                $('.total_active').html(OBJ.active);
                $('.total_inactive').html(OBJ.inactive);
            }

                if (result != '0') {
                    //toastr["success"]("Status Updated successfully!");
                } else {
                    //toastr["error"]("something went wrong. Please reload page and try again!");
                }
            }
        );
    }
}

function goBack() {
    window.history.back();
}


