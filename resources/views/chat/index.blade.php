@extends('layouts.app')
@section('content')
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <style>
        .chat-send button {
            width: auto;
        }
        #smiles img.m-t-2 {
            margin: 0px 1px 1px 0;
            box-shadow: -1px 0px 2px -1px black;
        }
        .chat-input {
            height: auto !important;
            min-height: 38px;
        }  </style>
    <div class="main-container m-t-20">
        <!-- Start content -->
   <?php
     // check user is company
          $avator = asset('assets/images/users/male.png');
            if ($user->image == '') {
                     if ($user->type == 'c') {
              $avator = asset('assets/images/users/company.png');
            }
          if($user->type == 'u' || $user->type == 'adm'){

               if ($user->gender == 'm') {
                 $avator = asset('assets/images/users/male.png');
               }
            if ($user->gender == 'f') {
              $avator = asset('assets/images/users/female.png');
            }
          }

   } else {
   $avator = asset('assets/images/users/' . $user->image . '');
     }
   ?>

<div class="container">
 <div class="row">
  <div class="col-md-12">
             <!-- Chat Room    ================================================= -->
 <div class="chat-room">
    <div class="row">
 <div class="col-md-4">
<!-- Contact List in Left-->
 <a href="{{route('chat.create')}}">test chat page</a>
 <div class="card-box">
<ul class="nav nav-pills">
<li class="active"><a data-toggle="pill" href="#inboxed">Inbox</a></li>
 <li><a data-toggle="pill" href="#send">Sent</a>
   </li>
 </ul>
<div class="tab-content">
<div id="inboxed" class="tab-pane fade in active">
<h3>INBOX</h3>
<input id="chat_head" type="hidden" class="chathead" data-for="">
                                            <div class="inbox-widget nicescroll mx-box" tabindex="5000" style="overflow: hidden; outline: none;">
                                            @if(count($inbox) > 0 )
                                                @foreach($inbox as $value)
                                                    <!--<button onclick="deleteRow(this)" data-obj="chat" data-id="{{ $value->id }},{{ $user->id }}" class="btn btn-sm btn-danger pull-right"><i class="fa fa-minus" aria-hidden="true"></i></button>-->
                                                        <a href="javascript:void(0);" class="chathead" data-for="{{ $value->id }}">
                                                            <div class="inbox-item">
                                                                <div class="inbox-item-img"><img src="{{ $avator}}" class="img-circle" alt="">
                                                                </div>

 <p class="inbox-item-author">{{ ucwords($value->name) }}
                                                                    <i title="{{ ($value->is_login)? 'Online User': 'Offline User'  }}"
                                                                       class="fa fa-circle pull-right {{ ($value->is_login)? 'online': 'offline'  }}"></i>
                                                                </p>
                                                                <p class="inbox-item-text">Hey! there I'm available...</p>
                                                                <p class="inbox-item-date">{{ date('h:i A', strtotime($value->created_at)) }}</p>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <p class="text-danger">Empty inbox. You haven't received any message yet! </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div id="send" class="tab-pane fade">

 <h3>SEND</h3>

<input id="chat_head" type="hidden" class="chathead" data-for="">
                                            <div class="inbox-widget nicescroll mx-box" tabindex="5000" style="overflow: hidden; outline: none;">
                                            @if(count($sent) > 0 )
                                                @foreach($sent as $value)
                                                  <a href="javascript:void(0);" class="chathead" data-for="{{ $value->id }}">
                                                            <div class="inbox-item">
                                                                <div class="inbox-item-img"><img src="{{$avator}}" class="img-circle"
                                                                                                 alt="">
                                                                </div>

 <p class="inbox-item-author">{{ ucwords($value->name) }}
                                                                    <i title="{{ ($value->is_login)? 'Online User': 'Offline User'  }}"
                                                                       class="fa fa-circle pull-right {{ ($value->is_login)? 'online': 'offline'  }}"></i>
                                                                </p>
                                                                <p class="inbox-item-text">Hey! there I'm
                                                                    available...</p>
                                                                <p class="inbox-item-date">{{ date('h:i A', strtotime($value->created_at)) }}</p>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                @else
                         <p class="text-danger">Empty Sent.
                                                        You haven't send any message yet! </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <!--Chat Messages in Right-->
                                <!-- CHAT -->
                                <div class="card-box">
                                    <h4 class="m-t-0 m-b-20 header-title"><b>Chat</b>
                                        <span class="whochat"></span></h4>
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
                                                    <a data-toggle="modal" data-target="#emojiModal"
                                                       class="btn btn-md btn-sm btn-inverse">
                                                        <i class="fa fa-smile-o fa-2x" aria-hidden="true"></i></a>
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

<!-- Modal Emoji -->
<div class="modal fade top-80" id="emojiModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
             aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="modelTitleId">Add Emoticons</h4>
                    </div>
                    <div class="modal-body">
                        <div class="nicescroll" id="smiles">
                            <?php
                            echo '<div>';
                            for ($i = 1; $i < 119; $i++) {
                                echo '<span class="get_emoji" ><img class="m-t-2" src = "' . asset('assets/images/emoji/smiles/sm' . $i . '.png') . '" alt = "" ></span>';

}
echo '</div>';
echo '<div id="flags">';

for ($i = 1; $i < 259; $i++) {

 echo '<span class="get_emoji"><img class="m-t-2" src="' . asset('assets/images/emoji/flags/' . $i . '.png') . '" alt=""></span>';
                            }
                            echo '</div>';
                            echo '<div id="animals">';
                            for ($i = 1; $i < 73; $i++) {
                                echo '<span class="get_emoji"><img class="m-t-2" src="' . asset('assets/images/emoji/animals/' . $i . '.png') . '" alt=""></span>';
                            }
                            echo '</div>';
                            echo '<div id="car">';
                            for ($i = 1; $i < 13; $i++) {
                                echo '<span class="get_emoji"><img class="m-t-2" src="' . asset('assets/images/emoji/vahicles/' . $i . '.png') . '" alt=""></span>';
                            }
                            echo '</div>';
                            echo '<div id="car">';
                            for ($i = 1; $i < 111; $i++) {
                                echo '<span class="get_emoji"><img class="m-t-2" src="' . asset('assets/images/emoji/flower/' . $i . '.png') . '" alt=""></span>';
                            }
                            echo '</div>';
                            echo '<div id="symbols">';
                            for ($i = 0; $i < 58; $i++) {
                                echo '<span class="get_emoji"><img class="m-t-2" src="' . asset('assets/images/emoji/symbols/' . $i . '.png') . '" alt=""></span>';
                            }
                            echo '</div>';
                            echo '<div id="buildings">';
                            for ($i = 1; $i < 33; $i++) {
                                echo '<span class="get_emoji"><img class="m-t-2" src="' . asset('assets/images/emoji/buildings/' . $i . '.png') . '" alt=""></span>';
                            }
                            echo '</div>';
                            echo '<div id="family">';
                            for ($i = 1; $i < 33; $i++) {
echo '<span class="get_emoji"><img class="m-t-2" src="' . asset('assets/images/emoji/family/' . $i . '.png') . '" alt=""></span>';
                            }
                            echo '</div>';
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
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
        <?php exit; ?>
        <script>
            $(document).ready(function () {
                // add emoji
                $('.get_emoji').click(function () {
                    var $emoji = $(this).html();
                    $('.chat-input').append(' ' + $emoji + '&nbsp; ');
                });
                //
                var id = $('.chathead[data-for="' + $.cookie('chatHead') + '"]').data('for');
                if (id === undefined) {
                    $('#chat_head').attr('data-for', $.cookie('chatHead'));
                    $('.chathead').trigger("click");
                } else {
                    $('.chathead[data-for="' + $.cookie('chatHead') + '"]').trigger("click");
                }
                if (typeof($.cookie('chatHead')) === "undefined") {
                    $('.col-md-8 .header-title').addClass('hidden');
                    //$('#chatForm').addClass('hidden');
                    console.log('undefined');
                } else {
                    $('#target').val($.cookie('chatHead'));
                    $('.whochat .label').html('{{ $user->name }} & ' + $.cookie('chatUser'));
                    $('.col-md-8 .header-title, #chatForm').removeClass('hidden');
                }
            });
            $('.chathead').on('click', function () {
                $('#load_chat').html('');
                $('.msg-thread').remove();
                $('#load_chat').html('<center style="padding-top: 100px"><i class="fa fa-spinner fa-spin"></i></center>');
                var forchat = $(this).data('for');
                $.cookie('chatHead', forchat, {path: '/'});
                $('#target').val(forchat);
                var name = $(this).find('.inbox-item-author').text();
                $('.whochat').html('<small class="label label-info"> {{ $user->name }} & ' + name + ' </small>').addClass('pull-right').addClass('text-capitalize');
                $.post(
                    '{{route('load_chat_head')}}',
                    {id: forchat},
                    function (data) {
                        $('#load_chat').html(data);
                        // scroll down
                        $(".conversation-list").scrollTop($(".conversation-list")[0].scrollHeight);
                        $('.badge-white').html('0');
                    }
                    )
            });
            !function ($) {
                "use strict";
                var ChatApp = function () {
                    this.$body = $("body"),
                        this.$chatInput = $('.chat-input'),
                        this.$chatList = $('.conversation-list'),
                        this.$chatSendBtn = $('.chat-send button')
                };
                setInterval(function () {
                        var to = $('#target').val();
                        $.post(
                            '{{route('load_chat_message')}}',
                            {id: to},
                            function (data) {
                                $('.conversation-list').append(data);
                                if (data != '') {
                                    $(".conversation-list").scrollTop($(".conversation-list")[0].scrollHeight);
                                }
                            }
                            );
                    },
                    5000);
                //saves chat entry - You should send ajax call to server in order to save chat enrty
                ChatApp.prototype.save = function () {
                    var chatText = this.$chatInput.html();
                    var chatTime = moment().format("h:mm");
                    if (chatText == "") {
                        sweetAlert("Oops...", "You forgot to enter your chat message", "error");
                        this.$chatInput.focus();
                    } else {
                        // save chat message
                        var to = $('#target').val();
                        $.post(
                            '{{route('chat.store')}}',
                            {to: to, text: chatText},
                            function (data) {
                            }
                        );
                        this.$chatInput.html('');
                        $('<li class="clearfix msg-thread"><div class="chat-avatar"><img src="{{$avator}}" alt="male"><i>' + chatTime + '</i></div><div class="conversation-text"><div class="ctext-wrap"><i class="text-capitalize">{{$user->name}}</i><p>' + chatText + '</p></div></div></li>').appendTo('.conversation-list');
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
                function ($) {
                    "use strict";
                    $.ChatApp.init();
                }(window.jQuery);
        </script>
@endsection
        }
