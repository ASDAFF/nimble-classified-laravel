@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <style>
        .chat-send button{
            width: auto;
        }
        #smiles img.m-t-2 {
            margin: 0px 1px 1px 0;
            box-shadow: -1px 0px 2px -1px black;
        }
        .chat-input{
            height: auto!important;
            min-height: 38px;
        }
        #inboxed{
            border-right: 1px solid #ccc;
        }
        #reference{ position: relative; width: 80%; text-transform: capitalize}
        #reference .title, #reference .price{ position: absolute; font-weight: 500}
        #reference .title, #reference .price{right: 70px;}
        #reference .price{ top:20px;}



    </style>
    <section id="main" class="clearfix home-default">
        <div class="container">
            <div class="main-container m-t-20">
                <!-- Start content -->
                <?php
                // check user is company
                $avator = asset('assets/images/users/male.png');
                if($user->image ==''){
                    if($user->type == 'c' ){
                        $avator = asset('assets/images/users/company.png');
                    }
                    if($user->type == 'u' || $user->type == 'adm'){
                        if($user->gender == 'm'){
                            $avator = asset('assets/images/users/male.png');
                        }
                        if($user->gender == 'f'){
                            $avator = asset('assets/images/users/female.png');
                        }
                    }
                }else{
                    $avator = asset('assets/images/users/'.$user->image.'');
                }
                ?>
                <div class="main-container">
                    <div class="container">
                        <div class="row">
                            @include('user.sidebar')
                            <div class="section page-content">
                                <div class="inner-box">
                                    <h2 class="title-2"><i class="icon-docs"></i> Message
                                        <div id="reference" class="hidden pull-right">
                                            <span class="title"></span>
                                            <span class="price text-danger"></span>
                                            <img src="" alt="" height="50px" width="60px" class="pull-right">
                                        </div>
                                    </h2>
                                    <div class="col-md-4">
                                        <div id="inboxed" class="tab-pane fade in active">

                                            <input id="chat_head" type="hidden" class="chathead" data-for="" >
                                            <div class="inbox-widget nicescroll mx-box" tabindex="5000" style="overflow: hidden; outline: none;">
                                                @if(count($inbox) > 0 )
                                                    @foreach($inbox as $value)

                                                        <a href="javascript:void(0);" class="chathead" data-for="{{ $value->id }}" data-adid="{{ $value->ad_id }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $value->title }}">
                                                            <div class="inbox-item">
                                                                <div class="inbox-item-img"><img src="{{ $value->image!=''? asset('assets/images/users/'.$value->image.'') :  $avator}}" class="img-circle" alt=""></div>
                                                                <p class="inbox-item-author">{{ ucwords($value->name) }} <i title="{{ ($value->is_login)? 'Online User': 'Offline User'  }}"  class="fa fa-circle pull-right {{ ($value->is_login)? 'online': 'offline'  }}"></i></p>
                                                                <p class="inbox-item-text">Hey! there I'm available...</p>
                                                                <p class="inbox-item-date">{{ date('h:i A', strtotime($value->created_at)) }}</p>
                                                            </div>
                                                        </a>

                                                    @endforeach
                                                @else
                                                    <p class="text-danger">Empty inbox.
                                                        You haven't received any message yet!  </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="m-t-5 m-b-20 header-title"> <span class="whochat"></span> </h4>
                                        <div class="chat-conversation">
                                            <ul class="conversation-list nicescroll">
                                                <div id="load_chat"></div>
                                            </ul>
                                            <div class="row">
                                                <form action="" id="chatForm" onsubmit="return false">
                                                    {{ csrf_field() }}
                                                    <div class="col-sm-9 chat-inputbar">
                                                        <div contenteditable="" class="form-control chat-input"></div>
                                                        {{--<input type="text" class="form-control chat-input" placeholder="Enter your text">--}}
                                                    </div>
                                                    <div class="col-sm-3 chat-send">
                                                        <button type="submit" class="btn btn-md btn-success">Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="target" value="">
    <!-- jQuery  -->
    <script src="{{ asset('assets/js/moment.js') }}"></script>
    {{--<script src="{{ asset('assets/js/jquery.chat.js') }}"></script>--}}
    <!-- cookie -->
    <script src="{{asset('assets/js/cookie.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('assets/js/core.js') }}"></script>

    <script>
        $(document).ready(function() {
            // add emoji

            $('.get_emoji').click(function () {

                var $emoji =  $(this).html();
                $('.chat-input').append(' '+$emoji+'&nbsp; ');

            });
            //
            var id = $('.chathead[data-for="' + $.cookie('messageHead') + '"]').data('for');

            if (id === undefined) {
                $('#chat_head').attr('data-for', $.cookie('messageHead'));
                $('.chathead').trigger("click");
            } else {
                $('.chathead[data-for="' + $.cookie('messageHead') + '"]').trigger("click");
            }

            if (typeof($.cookie('messageHead')) === "undefined")
            {
                $('.col-md-8 .header-title').addClass('hidden');
                //$('#chatForm').addClass('hidden');
                console.log('undefined');
            }else{
                $('#target').val($.cookie('messageHead'));

                $('.whochat .label').html('{{ $user->name }} & ' + $.cookie('messageUser'));
                $('.col-md-8 .header-title, #chatForm').removeClass('hidden');
            }

        });

        $('.chathead').on('click', function () {

            $('#load_chat').html('');
            $('.msg-thread').remove();
            var ad_id = $(this).data('adid');

            $.cookie('messageAdId', ad_id, { path: '/' });

            $('#load_chat').html('<center style="padding-top: 100px"><i class="fa fa-spinner fa-spin"></i></center>');
            var forchat = $(this).data('for');
            $.cookie('messageHead', forchat, { path: '/' });

            $('#target').val(forchat);
            var name = $(this).find('.inbox-item-author').text();
            $.post(
                '{{route('load_message_head')}}',
                {id:forchat, ad_id:ad_id},
                function(data){
                    $('#load_chat').html(data);
                    // scroll down
                    $(".conversation-list").scrollTop($(".conversation-list")[0].scrollHeight);
                    $('.badge-white').html('0');
                }
            );
            // get message reference
            $.get(
                '{{url('load_message_reference')}}',
                {ad_id:ad_id},
                function(res){
                    if(res!=''){
                        $('#reference').removeClass('hidden');
                        $('#reference img').attr('src', res.image);
                        $('#reference .title').html(res.title);
                        $('#reference .price').html(res.price + '€');

                        $('.whochat').html( '<small class="label label-info"> {{ $user->name }} & '+ name+' </small>').addClass('pull-right').addClass('text-capitalize');
                    }
                }
            )
        });


        !function($) {
            "use strict";

            var ChatApp = function() {
                this.$body = $("body"),
                    this.$chatInput = $('.chat-input'),
                    this.$chatList = $('.conversation-list'),
                    this.$chatSendBtn = $('.chat-send button')
            };

            setInterval(function() {
                    var to = $('#target').val();
                    var ad_id = $.cookie('messageAdId');
                    $.post(
                        '{{route('load_message')}}',
                        {id:to, ad_id:ad_id},
                        function(data){
                            $('.conversation-list').append(data);
                            if(data != ''){
                                $(".conversation-list").scrollTop($(".conversation-list")[0].scrollHeight);
                            }
                        }
                    );
                },
                5000);

            //saves chat entry - You should send ajax call to server in order to save chat enrty
            ChatApp.prototype.save = function() {

                var chatText = this.$chatInput.html();
                var chatTime = moment().format("h:mm");
                if (chatText == "") {
                    sweetAlert("Oops...", "You forgot to enter your chat message", "error");
                    this.$chatInput.focus();
                } else {
                    // save chat message
                    var to = $('#target').val();
                    var ad_id = $.cookie('messageAdId');
                    $.post(
                        '{{route('message.store')}}',
                        {to:to, text:chatText, ad_id:ad_id},
                        function(data){
                        }
                    );
                    this.$chatInput.html('');

                    $('<li class="clearfix msg-thread"><div class="chat-avatar"><img src="{{$avator}}" alt="male"><i class="fa fa-clock-o">' + chatTime + '</i></div><div class="conversation-text"><div class="ctext-wrap"><i class="text-capitalize">{{$user->name}}</i><p>' + chatText + '</p></div></div></li>').appendTo('.conversation-list');
                    this.$chatInput.val('');
                    this.$chatInput.focus();

                    $(".conversation-list").scrollTop($(".conversation-list")[0].scrollHeight);
                }
            },
                ChatApp.prototype.init = function () {
                    var $this = this;
                    //binding keypress event on chat input box - on enter we are adding the chat into chat list -
                    $this.$chatInput.keypress(function (ev) {
                        var p = ev.which;
                        if (p == 13) {
                            $this.save();
                            return false;
                        }
                    });

                    //binding send button click
                    $this.$chatSendBtn.click(function (ev) {
                        $this.save();
                        return false;
                    });
                },
                //init ChatApp
                $.ChatApp = new ChatApp, $.ChatApp.Constructor = ChatApp

        }(window.jQuery),

//initializing main application module
            function($) {
                "use strict";
                $.ChatApp.init();
            }(window.jQuery);
    </script>
@endsection
