<style>
#chat .chat {
  list-style: none;
  margin: 0;
  padding: 0;
}
#chat .chat li {
  margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #B3A9A9;
    }
    #chat .chat li.left .chat-body {
        margin-left: 48px;
        text-align: left;
    }
    #chat .chat li.right .chat-body {
        margin-right: 48px;
        text-align: left;
    }
    #chat .chat li .chat-body p {
        margin: 0;
        color: #777777;
    }
    #chat .panel .slidedown .glyphicon, .chat .glyphicon {
        margin-right: 5px;
    }
    #chat .chat-panel{
        overflow-y: scroll;
        height: 250px;
    }
    #chat .panel-body::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }
    #chat .panel-body::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
    }
    #chat .panel-body::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #555;
    }
    #chat
    {
        position:fixed;
        width:280px;
        height:auto;
        color:#EDEDED;
        font-family:Cambria;
        bottom:0px;
        right:15px;
        cursor:pointer;
        z-index: 80000;
        font-family: "Roboto Condensed", Helvetica, Arial, sans-serif;
    }
    #chat .panel{
        margin-bottom: 0px !important;
    }
    #chat .chat-img img{
        height:40px!important;
        width: 40px!important;
    }
    #chat .btn-indicator, .btn-settings{
        background: #337ab7;
        border: none;
        color: white;
        height:40px;
        box-shadow: none!important;
    }
    #btn-input{
        min-height: 29px;
        height:auto;
    }
    #chat .panel-footer{
        position: relative;
    }
    #chat .panel-footer .emoji{
        position: absolute;
        width: 218px;
        background-color: #ffffff;
        color: black;
        bottom: 58px;
        text-align: left;
        /* border: 1px solid #ddd; */
        box-shadow: 2px 5px 22px -8px #373737;
    }
    .emoji_body{
        height: 200px;
        overflow: auto;
        padding: 3px!important;
    }
    #btn-input img , img.m-t-2{
        height: 18px !important;
    }
    #chat .chat{
        color: #000;
    }
    .emoji a.btn.btn-sm {
        padding: 1px 5px !important;
    }
    .emoji .panel-footer {
        padding: 8px 8px!important;
    }
    div#btn-input:hover {
        cursor: text;
    }
    #chat .panel-footer .input-group .form-control {
        padding-left: 2px;
    }
    /* shake  */
    @-webkit-keyframes spaceboots {
        0% { -webkit-transform: translate(2px, 1px) rotate(0deg); }
        10% { -webkit-transform: translate(-1px, -2px) rotate(-1deg); }
        20% { -webkit-transform: translate(-3px, 0px) rotate(1deg); }
        30% { -webkit-transform: translate(0px, 2px) rotate(0deg); }
        40% { -webkit-transform: translate(1px, -1px) rotate(1deg); }
        50% { -webkit-transform: translate(-1px, 2px) rotate(-1deg); }
        60% { -webkit-transform: translate(-3px, 1px) rotate(0deg); }
        70% { -webkit-transform: translate(2px, 1px) rotate(-1deg); }
        80% { -webkit-transform: translate(-1px, -1px) rotate(1deg); }
        90% { -webkit-transform: translate(2px, 2px) rotate(0deg); }
        100% { -webkit-transform: translate(1px, -2px) rotate(-1deg); }
    }
    .shake{
        -webkit-animation-name: spaceboots;
        -webkit-animation-duration: 0.8s;
        -webkit-transform-origin:50% 50%;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: linear;
    }
    .fa-wechat{
        font-size: 30px;
    }
    .p-3-6{
        padding: 3px 6px !important;
    }
    .font-20{
        font-size: 20px;
    }
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-text)
    }
    .setting-container{
        color: black;
        border-bottom: 1px solid #ccc;
        /* height: 32px; */
        padding: 5px 2px;
        margin-bottom: 5px;
    }
    .block-all:hover{
        color: #ff6620;
    }
    .hide{display: none}
</style>
<?php
// check user is company
$avator = '';
if(Auth::user()->image ==''){
    if(Auth::user()->type == 'c' ){
        $avator = asset('assets/images/users/company.png');
    }
    if(Auth::user()->type == 'u' ){
        if(Auth::user()->gender == 'm'){
            $avator = asset('assets/images/users/male.png');
        }
        if(Auth::user()->gender == 'f'){
            $avator = asset('assets/images/users/female.png');
        }
    }
}else{
    $avator = asset('assets/images/users/'.Auth::user()->image.'');
}
?>
<div id="chat">
    <div class="panel panel-primary">
        <div class="btn-group pull-right">
            <!--<button class="btn btn-xs btn-default btn-settings hidden"><i class="fa fa-gear" aria-hidden="true"></i></button>-->
            <button class="btn btn-xs btn-default btn-indicator btn-setting"><i class="fa fa-angle-down" aria-hidden="true"></i></button>
        </div>
        <div class="panel-heading p-3-6">
            <span class="font-20"><span class="fa fa-wechat"></span> Live Chat  </span><i class="badge hidden chat_notIf">0</i>
        </div>
        <div class="panel-body chat-panel hidden" style="padding: 0px 2px 0 3px;">
            <div class="setting-container hidden" style="color: black">
                <button class="pull-left btn btn-xs btn-inverse btn-back"> < </button>
                <span class="pull-left"> &nbsp; Block users </span>
                <a href="javascript:void(0)"><span class="pull-right block-all"><i class="fa fa-lock"></i> {{ (!Auth::guest() && Auth::user()->chat_lock == 0)? 'Lock everything' : 'Everything Locked' }} </span></a>
                <div class="clearfix"></div>
            </div>
            <ul class="chat">
                <li class="hidden"></li>
            </ul>
        </div>
        <div class="panel-footer hidden {{ (!Auth::guest() && Auth::user()->chat_lock == 0)? '' : 'hide' }}">
            <div class="input-group">
                <div contenteditable=true data-text="Enter text here"  id="btn-input" class="form-control input-sm text-left" ></div>
                <span class="input-group-btn emoji_btn">
                    <a class="btn btn-sm btn-link" id="btn-chat">
                        <i class="fa fa-smile-o" aria-hidden="true"></i>
                    </a>
                </span>
            </div>
            <!-- emoji -->
            <div class="emoji hidden">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-smile-o fx-2" aria-hidden="true"></i>
                        <span> Add Emojione </span>
                    </div>
                    <div class="panel-body emoji_body">
                        <center class="hidden"> <i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </center>
                        <div id="load_emoji"></div>
                    </div>
                    <div class="panel-footer">
                        <a data-toggle="tooltip" data-placement="left" href="#smiles" title="Smiles & emotions" class="btn btn-sm"><i class="fa fa-smile-o" aria-hidden="true"></i></a>
                        <a data-toggle="tooltip" data-placement="bottom" href="#family" title="Family" class="btn btn-sm"><i class="fa fa-users" aria-hidden="true"></i></a>
                        <a data-toggle="tooltip" data-placement="bottom" href="#car" title="Vehicles" class="btn btn-sm"><i class="fa fa-car" aria-hidden="true"></i></a>
                        <a data-toggle="tooltip" data-placement="bottom" href="#flower" title="Flower & fruits" class="btn btn-sm"><i class="fa fa-apple" aria-hidden="true"></i></a>
                        <a data-toggle="tooltip" data-placement="bottom" href="#flags" title="Flags" class="btn btn-sm"><i class="fa fa-flag" aria-hidden="true"></i></a>
                        <a data-toggle="tooltip" data-placement="bottom" href="#animals" title="Animals" class="btn btn-sm"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a data-toggle="tooltip" data-placement="bottom" href="#buildings" title="Buildings" class="btn btn-sm"><i class="fa fa-building" aria-hidden="true"></i></a>
                        <a data-toggle="tooltip" data-placement="right" href="#symbols" title="Diresction" class="btn btn-sm"><i class="fa fa-arrows" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cookie -->
<script src="{{asset('assets/js/cookie.js')}}"></script>
<script>
    var hide_chat = "{{ (!Auth::guest() && Auth::user()->chat_lock == 0)? '' : 'hide' }}";
    var is_emoji = false;
    $(document).ready(function () {
        // block all users
        $(document).on('click', '.block-all', function () {
            $.get('{{ url('lock_all') }}', function (result) {
                //console.log(result);
                if(result!=''){
                    if(result == 1){ // lock
                        hide_chat = 'hide';
                        $('#chat .chat').html('');
                        $('#chat #btn-input, .emoji_btn').addClass('hidden');
                        $('.block-all').text('Everything locked');
                    }else{ // unlock
                        hide_chat = '';
                        $('.btn-settings').click();
                        $('#chat #btn-input, .emoji_btn').removeClass('hidden');
                        $('.block-all').text('lock Everything');
                    }
                }
                //console.log(hide_chat);
            });
        });
        // load chat on back button
        $(document).on('click', '.btn-back', function () {
            $('.setting-container').addClass('hidden');
            // load chat of user
            var to = $.cookie('chatHead');
            console.log(hide_chat);
            if(hide_chat != 'hide') {
                $.post(
                    '{{route('load_chat_head')}}',
                    {id: to},
                    function (data) {
                        if (data !=0 ) {
                            $('#chat .chat').html(data);
                            // scroll down
                            $("#chat .panel-body").scrollTop($("#chat .panel-body")[0].scrollHeight);
                            $('.badge-white').html('0');
                        } else {
                            $('.chat-panel').css('background', '');
                            $('.panel-footer .input-group').addClass('hidden');
                            $('#chat .chat').html('<center> There are not any chats yet </center>');
                        }
                    }
                );
            }else{
                $('#chat .chat').html('<center class="text-danger"> Chat is locked! </center>').removeClass('hide');
            }
        });
        //
        $(document).on('click', '#del_blocked', function () {
            var id =  $(this).data('id');
            var obj = 'chat_setting';
            if (id!='') {
                swal({
                        title: "Are you sure?",
                        text: "You cannot recover it later.",
                        type: "error",
                        showCancelButton: true,
                        cancelButtonClass: 'btn-default btn-md waves-effect',
                        confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                        confirmButtonText: 'Confrim!'
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $("#loading").show();
                            $.post('{{ url('delete') }}', {id: id, obj: obj}, function (result) {
                                //console.log(result);
                                if(result!=''){
                                    $('#chat .chat #'+id).hide();
                                }
                                $('#loading').hide();
                            });
                        } else {
                            swal("Cancelled", "Your action has been cancelled!", "error");
                        }
                    }
                );
            }
        });
        $(document).on('click', '.btn-settings', function () {
            $('.setting-container').removeClass('hidden');
            $('#chat .chat').html('<center class="hidden"> <i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </center>');
            $.get('{{ url('load-block-users') }}' , function (data) {
                if(data!='') {
                    $.each(data, function (i, item) {
                        $('#chat .chat').append('<li id="'+item.id+'"> <span class="chat-img"> <img src="{{ asset('assets/images/users/male.png') }}"> '+item.name+'</span> <button id="del_blocked" data-id="'+item.id+'" type="button" class="pull-right btn btn-sm btn-danger"><i class="fa fa-trash"></i></span> </li>');
                    });
                }else{
                    $('#chat .chat').html('There are no users blocked.');
                }
            });
        });
        // load chat of user
        var to = $.cookie('chatHead');
        $.post(
            '{{route('load_chat_head')}}',
            {id:to},
            function(data){
                if(data != 0){
                    $('#chat .chat').html(data);
                    // scroll down
                    $("#chat .panel-body").scrollTop($("#chat .panel-body")[0].scrollHeight);
                    $('.badge-white').html('0');
                }else{
                    $('.chat-panel').css('background', '');
                    $('.panel-footer .input-group').addClass('hidden');
                    $('#chat .chat').html('<center> There are not any chats yet </center>');
                }
            }
        );
        // load messages
        setInterval(function() {
                var to = $.cookie('chatHead');
                $.post(
                    '{{route('load_chat_message')}}',
                    {id:to},
                    function(data){
                        if(data != ''){
                            $('#chat .chat').find('center').html('');
                            $('#chat .input-group').removeClass('hidden');
                            $('#chat .chat').append(data);
                            $("#chat .panel-body").scrollTop($("#chat .panel-body")[0].scrollHeight);
                            $("#chat .panel-body").hasClass('hidden')
                            {
                                var t_msg = $('.chat_notIf').html();
                                var total = parseInt(t_msg)+1;
                                $('.chat_notIf').html(total).removeClass('hidden');
                            }
                            // shake and notifications
                            if($('#chat .panel-body').hasClass('hidden')) {
                                $('.fa-wechat').addClass('shake');
                                var audio = new Audio('{{ asset('assets/notify.mp3') }}');
                                audio.play();
                            }
                        }
                    }
                );
            },
            5000);
        // add emoji
        $(document).on('click', '.get_emoji', function () {
            var $emoji =  $(this).html();
            $('#btn-input').append($emoji);
        });
        // show hide chat
        $('#chat .panel-heading span, #chat .btn-indicator').click(function () {
            if($('#chat .panel-body').hasClass('hidden')){
                $('#chat .panel-body,#chat .panel-footer, #chat .btn-settings ').removeClass('hidden');
                $('#chat .btn-indicator').html('<i class="fa fa-angle-up"></i>');
                $("#chat .panel-body").scrollTop($("#chat .panel-body")[0].scrollHeight);
                $('.fa-wechat').removeClass('shake');
                $('.chat_notIf').html('0').addClass('hidden');
            }else{
                $('#chat .panel-body,.panel-footer,#chat .btn-settings').addClass('hidden');
                $('#chat .btn-indicator').html('<i class="fa fa-angle-down"></i>');
            }
        });
        // show emoji div
        $('.panel-footer .emoji_btn').click(function () {
            $(".panel-footer .emoji").toggleClass('hidden');
            if(!$(".panel-footer .emoji").hasClass('hidden')){
                if(is_emoji == false){
                    $('.emoji_body center').removeClass('hidden');
                    $.get('{{url('load-emoji')}}', function(data) {
                        if(data){
                            $('.emoji_body center').addClass('hidden');
                            $('#load_emoji').html(data);
                            is_emoji = true;
                        }
                    });
                }
            }
        });
        // submit message
        $('#btn-input').keypress(function(e) {
            if(e.which == 13) {
                $('.emoji').addClass('hidden');
                var msg = $(this).html();
                if (msg == '') {
                    swal("Oops...", "You forgot to enter your chat message", "error");
                } else {
                    $('#chat .chat').find('center').html('');
                    // save chat message
                    var to = $.cookie('chatHead');
                    $.post(
                        '{{route('chat.store')}}',
                        { to: to, text: msg },
                        function (data) {
                        }
                    );
                    $(this).html('');
                    $('.chat').append('<li class="left clearfix">' +
                        '<span class="chat-img pull-left">' +
                        '<img src="{{ $avator }}" alt="User Avatar"  class="img-circle">' +
                        '</span>' +
                        '<div class="chat-body clearfix">' +
                        '<div class="user_name">' +
                        '<strong class="text-primary">{{ucwords(Auth::user()->name)}}</strong>' +
                        '</div>' +
                        '<p>' + msg + '</p>' +
                        '</div>' +
                        '</li>');
                    // scroll down
                    $("#chat .panel-body").scrollTop($("#chat .panel-body")[0].scrollHeight);
                }
                e.preventDefault();
            }
        });
        // show notifications
        setInterval(function() {
            $.post('{{ route('message_notify') }}', function(data){
                var obj = $.parseJSON(data);
                if(obj.total > 0){
                    var audio = new Audio('{{ asset('assets/notify.mp3') }}');
                    audio.play();
                    toastr["success"]('<a href="{{ route('message.index') }}"> ' + obj.notify.user_from.name.toUpperCase()+ '<br> <i class="icon-chat"></i> send you message! </a> ');
                }
                $('.chat_notify').html(obj.total_chat);
                //console.log(obj.total);
            });
            //
        }, 5000);
    });
</script>
