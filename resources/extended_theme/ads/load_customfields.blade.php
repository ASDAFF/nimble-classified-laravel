<?php
$is_date_picker = $is_date_range_picker = false;
$min_height = 500;
$html=$text=$radio=$file=$date=$checkbox=$textara=$url=$dateinterval=$dropdown='';
$desc = $startInscription = $endInscription = $data_type = $daterange_picker_id = $date_picker_id = '';
$startFormGroup = ' <div class="col-md-6"> <div class="form-group clearfix login-box">';
$endFormGroup = '</div></div>';
$count=1;


if(count($fields) == 0) {
die();
     // custom field is empty.
}
?>
@if(count($fields) > 0)

        @foreach($fields as $v)
            <?php
            $required= $star= '';
            // name attribute
                $name = 'cf['. str_replace(' ', '_', strtolower($v->name)).']['.$v->id.']';
                //$name =  str_replace(' ', '_', strtolower($v->name));
                // required and star
                if($v->required_field == 1){
                    $star = '<span class="text-danger"> *</span>';
                    $required = 'required';
                }
                //data type
                if($v->data_type == 'numeric'){  $data_type = 'onkeypress="validate(event,\'num\')" ';  }
                if($v->data_type == 'alphabets'){ $data_type = 'onkeypress="validate(event,\'alpha\')"'; }
                if($v->data_type == 'alpha_numeric'){ $data_type = ''; }
                // inscription
                if($v->inscription !=''){
                    $startInscription = '<div class="input-icon"><i>'.$v->inscription.'</i>';
                    $endInscription = '</div>';
                }
                //description
                if($v->description !=''){
                    $desc = '<span class="add-type tooltipHere" data-toggle="tooltip" data-placement="right" title="'.$v->description.'"> <i class="fa fa-question-circle-o"></i> </span>';
                }
            // text
            if($v->type == 'text'){
                    $text .= $startFormGroup;
                    $text .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.'</label>
                    <div class=" m-b-155">
                        '.$startInscription.'
                        <input type="'.$v->type.'" '.$data_type.' class="form-control" name="'.$name.'" '.$required.' />
                        '.$endInscription.'
                    </div>
                    ';
                    $text .= $endFormGroup;
            }
            // date
            if($v->type == 'date'){
                $is_date_picker = true;
                $date_picker_id .='#datepicker_'.$count.',';
                    $date .= $startFormGroup;
                    $date .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.'</label>
                    <div class=" m-b-155">
                        <div class="input-icon"><i class="fa fa-calendar"></i>
                        <input type="text" class="form-control" name="'.$name.'" '.$required.' placeholder="mm/dd/yyyy" id="datepicker_'.$count.'" />
                        '.$endInscription.'
                    </div></div>
                    ';
                    $date .= $endFormGroup;
            }
            // date interval
            if($v->type == 'dateinterval'){
                $is_date_range_picker = true;
                $daterange_picker_id .='#input-daterange_'.$count.',';
                    $dateinterval .= $startFormGroup;
                    $dateinterval .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.'</label>
                    <div class=" m-b-155">
                        <div class="input-icon"><i class="fa fa-calendar"></i>
                        <input type="text" class="form-control" name="'.$name.'" '.$required.' placeholder="mm/dd/yyyy" id="input-daterange_'.$count.'" />
                        '.$endInscription.'
                    </div></div>
                    ';
                    $dateinterval .= $endFormGroup;
            }
            // checkbox
            if($v->type == 'checkbox'){
                    $checkbox .= $startFormGroup;
                    $checkbox .= '
                    <div class="col-lg-10 m-b-155">
                    <label class=" control-label"><input type="'.$v->type.'" '.$data_type.' value="1" name="'.$name.'" '.$required.' />   '.ucfirst($v->name).' '.$star.'  '.$desc.'</label>
                    </div>';
                    $checkbox .= $endFormGroup;
            }
            // file
            if($v->type == 'file'){
                    $file .= '<div class="clearfix"></div>
                    <div class="col-md-12 row">';
                    $file .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.' </label>
                    <div class=" m-b-155">
                        <input type="'.$v->type.'" '.$data_type.' name="'.$name.'" '.$required.' class="filestyle" data-input="false" />
                    </div>
                    ';
                    $file .= $endFormGroup;
            }
            // url
            if($v->type == 'url'){
                    $url .= $startFormGroup;
                    $url .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.'</label>
                    <div class=" m-b-155">
                        <input type="'.$v->type.'" '.$data_type.'  class="form-control" name="'.$name.'" '.$required.' />
                    </div>
                    ';
                    $url .= $endFormGroup;
            }

            // dropdown
            if($v->type == 'dropdown'){
                    $dropdown .= $startFormGroup;
                    $dropdown .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.'</label>
                    <div class=" m-b-155">
                        <select type="'.$v->type.'" '.$data_type.'  class="form-control selecter" name="'.$name.'" '.$required.'>';
                if($v->options !=''){
                    foreach(explode(',', $v->options) as $value){
                        $dropdown.= '<option value="'.$value.'">'.$value.'</option>';
                    }
                }
                        $dropdown.='</select>
                    </div>
                    ';
                    $dropdown .= $endFormGroup;
            }

            // textarea
            if($v->type == 'textarea'){
                    $checkbox .= '<div class="clearfix"></div>
                    <div class="col-md-12 row">';
                    $checkbox .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.'</label>
                    <div class=" m-b-155">
                        <textarea type="'.$v->type.'" '.$data_type.' class="form-control" rows="5" name="'.$name.'" '.$required.' ></textarea>
                    </div>
                    ';
                    $checkbox .= $endFormGroup;
            }

            // radio
            if($v->type == 'radio'){

                $radio .= '<div class="clearfix"></div>
                    <div class="col-md-12 row">';
                $radio .= '
                    <label class=" control-label"> '.ucfirst($v->name).' '.$star.'  '.$desc.'</label><br>
                    <div class=" m-b-155 m-l-20 radio radio-info radio-inline">';
                if($v->options !=''){
                    foreach(explode(',', $v->options) as $index => $value){
                        $radio.= '
                        <input id="radio_'.$index.'" type="'.$v->type.'" class="" name="'.$name.'" '.$required.' value="1" />
                       <label for="radio_'.$index.'" ><span class="m-r-25"> '.ucfirst($value).' </span></label>  ';
                    }
                }
                $radio.='</div>';
                $radio .= $endFormGroup;
            }
        // data combine
            $html = $text.$url.$dropdown.$date.$dateinterval.$radio.$checkbox.$textara.$file;
            $count++;
            ?>
        @endforeach
{!! $html !!}
        <!-- End foreach -->
 @else
    {{--<p class="alet alet-danger"> Custom field not found!</p>--}}
@endif

<?php
$group_html = '';
$group_count = 0;
if(count($groups) > 0){
    foreach($groups as $item){
$group_html .= '
    <div class="clearfix"></div>
    <h3> '.ucfirst($item['group_title']).'  </h3>
    <div class="col-md-12 bg-white p-10">
    ';
        foreach($item['group_fields'] as $value){
            $group_html .='
                    <div class="col-md-4 col-xs-4">
                        <div class="form-group">
                            <label for="group_'. $value['id'].'">
                                <input id="group_'. $value['id'].'" value="1" onclick="check_group('.$value['id'].')" type="checkbox" name="group['.strtolower( str_replace(' ', '_', $value['title']) ).'#'.$value['id'].']['.$item['group_id'].']">
                                <input class="hidden" checked id="group_'. $value['id'].'_hidden" value="0" type="checkbox" name="group['.strtolower( str_replace(' ', '_', $value['title']) ).'#'.$value['id'].']['.$item['group_id'].']">
                                '. $value['title'] .'
                            </label>
                        </div>
                    </div> ';
            $group_count++;
        }
        $group_html .='<div class="clearfix"></div></div>';
    }
    echo '<div class=" groups ">'. $group_html .'</div>';
}
?>
<input type="hidden" id="content_height" value="{{(130.2*$count)+$min_height}}px">
<style>
    .groups h3{
        margin-top: 5px;
    }
    .p-10{
        padding: 10px;
    }
    .p-05{
        padding:0px 5px 0px 5px;
    }
    @if($count > 4)
        .wizard > .content{ min-height: {{(120.2*($count))+$min_height}}px;}
    @else
        .wizard > .content{ min-height: 75em;}
    @endif


</style>

@if($is_date_picker)

<link href="{{asset('admin_assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

<script src="{{asset('admin_assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
@endif

@if($is_date_range_picker)
<script src="{{asset('admin_assets/plugins/moment/moment.js')}}"></script>
<link href="{{asset('admin_assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
<script src="{{asset('admin_assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
@endif
<!-- file select  -->
<script src="{{ asset('admin_assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')  }}"></script>


<script>

    function check_group(id){

        if($('#group_'+id).is(':checked')){
            $('#group_'+id+'_hidden').attr('checked', false);
        }else{
            $('#group_'+id+'_hidden').attr('checked', true);
        }
    }

    $(document).ready(function () {
        @if($is_date_picker)
        // Date Picker
        jQuery('{{ rtrim($date_picker_id, ',') }}').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        @endif
        @if($is_date_range_picker)
        //Date range picker
        $('{{ rtrim($daterange_picker_id, ',') }}').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-default',
            format: "yyyy-mm-dd",
        });
        @endif

        // remove class
        $('.icon-span-filestyle').removeClass('icon-span-filestyle');

    });

    function validate(evt, type ) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        if(type == 'num') {
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
                swal('Alert', ' Only numeric values are allowed! ', 'error')
            }
        }
        if(type == 'alpha') {
            var regex = /[a-zA-z ]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
                swal('Alert', ' Only alphabets values are allowed! ', 'error')
            }
        }
    }
</script>
<script src="{{ asset('assets/js/script.js') }}"></script>