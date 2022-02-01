<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\User;
use App\Chat;
Use App\Session;
use Response;

class ChatController extends Controller
{
    private  $notification_subject, $notification_to_email = "";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inbox = DB::table('chat')
            ->join('users', 'users.id', '=', 'chat.from')
            ->select('users.id', 'users.is_login' ,'users.name', 'users.image','users.type','users.gender', 'chat.created_at')
            ->where( [ 'chat.to' => Auth::user()->id ])
            //->orWhere('chat.from' , Auth::user()->id )
            ->groupBy('chat.from')
            ->get();


        $sent = DB::table('chat')
            ->join('users', 'users.id', '=', 'chat.to')
            ->select('users.id', 'users.is_login' ,'users.name', 'users.image','users.type','users.gender', 'chat.created_at')
            //->where( [ 'chat.to' => Auth::user()->id ])
            ->where('chat.from' , Auth::user()->id )
            ->groupBy('chat.to')
            ->get();


        $user = Auth::user();
        return view('chat.index', compact( 'user', 'friends', 'inbox', 'sent' ));
    }

    function loadChatHead(Request $request)
    {

            $from = $request->id;

            $identifier1 = Auth::user()->id . ':' . $from;
            $identifier2 = $from . ':' . Auth::user()->id;

            $chat = DB::table('chat')
                ->join('users', 'users.id', '=', 'chat.from')
                ->select('users.id', 'users.name', 'users.image','users.type','users.gender', 'chat.text', 'chat.created_at')
                ->whereIn('identifier', [$identifier1, $identifier2])
                ->orderBy('created_at', 'asc')
                ->get()->toArray();

            //print_r($chat);
            $update = Chat::where([ 'to' => Auth::user()->id, 'from' => $from ] )->update(['is_checked' => 1]);

        if( count($chat) > 0 )
        {
            return view('chat.chat_head', compact('chat'));
        }else{
            echo 0;
        }
    }


    function loadChatMessage(Request $request)
    {
        //print_r($request->all());

        $from =$request->id;
        if($from!='')
        {
            $chat = DB::table('chat')
                ->join('users', 'users.id', '=', 'chat.from')
                ->select('users.id', 'users.name', 'users.image', 'users.type', 'users.gender', 'chat.id as chat_id', 'chat.text', 'chat.created_at')
                ->where('chat.from', $from)
                ->where('chat.to', Auth::user()->id)
                ->where('is_checked', 0)
                ->orderBy('chat.id', 'desc')
                ->limit(1)
                ->get();

            if (isset($chat[0]))
            {
                $update = Chat::where('id', $chat[0]->chat_id)->update(['is_checked' => 1]);
            }
            // test
            $from = DB::table('chat')
                ->join('users', 'users.id', 'chat.from')
                ->select('users.id', 'users.name')
                ->where(['chat.to' => Auth::user()->id])
                ->orderBy('chat.id', 'desc')->limit(1)
                ->first();
            if($from){
              setcookie("chatHead", $from->id, time() + 3600, "/");
              setcookie("chatUser", $from->name, time() + 3600, "/");
            }
            return view('chat.chat_get_message', compact('chat'));
        }else{
            $from = DB::table('chat')
            ->join('users', 'users.id', 'chat.from')
                ->select('users.id', 'users.name')
            ->where(['chat.to' => Auth::user()->id])
                ->orderBy('chat.id', 'desc')->limit(1)
                ->first();
            if($from)
            {
                setcookie("chatHead", $from->id, time() + 3600, "/");
                setcookie("chatUser", $from->name, time() + 3600, "/");
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('chat.test', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $to = $request->to;
        if(!is_numeric($to))
        {
            echo 2;
            exit;
        }
        $text = $request->text;
        $identifier = Auth::user()->id .':'. $to ;
        $from = Auth::user()->id;
        $insert = DB::table('chat')->insertGetId([ 'identifier' =>  $identifier, 'text' => $text,'from' => $from, 'to' => $to ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function chatNotify()
    {
        $notify = '';
        $chat = Chat::with('userFrom')->select('id','from','to')->where([ 'to' => Auth::user()->id, 'is_checked' => 0, 'is_notify' => 0 ]);
        $total_ = Chat::where([ 'to' => Auth::user()->id, 'is_checked' => 0 ])->count();

        $total = $chat->count();
        if($total > 0)
        {
            $notify = $chat->first()->toArray();
            Chat::where([ 'to' => Auth::user()->id, 'is_checked' => 0, 'is_notify' => 0, 'id' => $notify['id'] ])->update(['is_notify' => 1]);
        }
        echo  json_encode([ 'total' => $total, 'total_chat' => $total_, 'notify' => $notify ]);
    }

    function loadEmoji()
    {

        return view('chat.emoji');
    }

    function load_block_users()
    {
        if(Auth::user()->chat_lock == 0 )
        {
            $data = DB::table('chat_setting')
                ->join('users', 'users.id', 'chat_setting.blocked_user')
                ->select('users.id', 'users.name')
                ->where('chat_setting.user_id', Auth::user()->id)->get();
            if ($data != '[]')
            {
                return Response::json($data);
            } else {
                return '';
            }
        }
    }
    function lock_all()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if( $user->chat_lock == 0 )
        {
           User::where('id', Auth::user()->id)->update([ 'chat_lock' => 1 ]);
            echo 1;
            exit;
        }

        if( $user->chat_lock == 1 )
        {
            User::where('id', Auth::user()->id)->update([ 'chat_lock' => 0 ]);
            echo 0;
            exit;
        }

    }
}
