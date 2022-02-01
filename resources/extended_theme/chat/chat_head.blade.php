@if( count($chat) > 0 )
    <?php $avator = asset('assets/images/users/male.png'); ?>
    @foreach($chat as $value)
        <?php
        if($value->image ==''){
            if($value->type == 'c' ){
                $avator = asset('assets/images/users/company.png');
            }
            if($value->type == 'u' || $value->type == 'adm' ){
                if($value->gender == 'm'){
                    $avator = asset('assets/images/users/male.png');
                }
                if($value->gender == 'f'){
                    $avator = asset('assets/images/users/female.png');
                }
            }
        }else{
            $avator = asset('assets/images/users/'.$value->image.'');
        }
        ?>
        <li class="{{ ( $value->id != Auth::user()->id )? 'right' : 'left'  }} clearfix">
            <span class="chat-img {{ ( $value->id != Auth::user()->id )? 'pull-right' : 'pull-left'  }}">
                <img src="{{ $avator }}" alt="User Avatar"  class="img-circle">
            </span>
            <div class="chat-body clearfix">
                <div class="user_name">
                    <p class="{{ ( $value->id != Auth::user()->id )? 'text-right' : 'text-left'  }}"><strong class="text-primary ">{{ ucwords($value->name) }}</strong></p>
                </div>
                <p>
                    {!! $value->text !!}
                </p>
            </div>
        </li>
    @endforeach
@else
2
@endif
