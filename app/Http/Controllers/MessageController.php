<?php

namespace App\Http\Controllers;

use App\Ads;
use Illuminate\Http\Request;

use Auth;
use DB;
use App\Message;
Use App\Session;
use Response;

class MessageController extends Controller
{
    private  $notification_subject, $notification_to_email = "";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inbox = DB::table('message')
            ->join('users', 'users.id', '=', 'message.from')
            ->join('ads', 'ads.id', '=', 'message.ad_id')
            ->select(
                'users.id',
                'users.is_login',
                'users.name',
                'users.image',
                'users.type',
                'users.gender',
                'message.created_at',
                'message.ad_id',
                'ads.title'
            )
            ->where( [ 'message.to' => Auth::user()->id ])
            //->orWhere('message.from' , Auth::user()->id )
            ->orderBy('message.id', 'desc')
            //->groupBy('message.ad_id')
            ->get();


        $user = Auth::user();
        return view('message.index', compact( 'user', 'friends', 'inbox' ));
    }

    function loadMessageHead(Request $request){

            $from = $request->id;

            $identifier1 = Auth::user()->id . ':' . $from;
            $identifier2 = $from . ':' . Auth::user()->id;

            $chat = DB::table('message')
                ->join('users', 'users.id', '=', 'message.from')
                ->select('users.id', 'users.name', 'users.image','users.type','users.gender', 'message.text', 'message.created_at')
                ->whereIn('identifier', [$identifier1, $identifier2])
                ->where('ad_id', $request->ad_id)
                ->orderBy('created_at', 'asc')
                ->get()->toArray();

            //print_r($chat);
            $update = Message::where([ 'to' => Auth::user()->id, 'from' => $from ] )->update(['is_checked' => 1]);

        if( count($chat) > 0 )
        {
            return view('message.chat_head', compact('chat'));
        }else{
            echo "<div class='text-danger'>You haven't chat message yet!</div>";
        }
    }


    function loadMessage(Request $request){
        //print_r($request->all());

        $from =$request->id;
        if($from!='')
        {
            $chat = DB::table('message')
                ->join('users', 'users.id', '=', 'message.from')
                ->select('users.id', 'users.name', 'users.image', 'users.type', 'users.gender', 'message.id as chat_id', 'message.text', 'message.created_at')
                ->where('message.from', $from)
                ->where('message.to', Auth::user()->id)
                ->where(['is_checked' => 0, 'ad_id' => $request->ad_id ])
                ->orderBy('message.id', 'desc')
                ->limit(1)
                ->get();

            if (isset($chat[0]))
            {
                $update = Message::where('id', $chat[0]->chat_id)->update(['is_checked' => 1]);
                Ads::where(['id' => $request->ad_id])->increment('message');
            }
            return view('message.chat_get_message', compact('chat'));
        }
    }

    public function create()
    {
        $user = Auth::user();
        return view('message.test', compact('user'));
    }

    public function store(Request $request)
    {
        $to = $request->to;
        $ad_id = $request->ad_id;
        if(!is_numeric($to))
        {
            echo 2;
            exit;
        }
        $text = $request->text;
        $identifier = Auth::user()->id .':'. $to ;
        $from = Auth::user()->id;
        $insert = DB::table('message')->insertGetId([ 'identifier' =>  $identifier, 'text' => $text,'from' => $from, 'to' => $to, 'ad_id' => $ad_id ]);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    function messageNotify()
    {
        $notify = '';
        $chat = Message::with('userFrom')->select('id','from','to')->where([ 'to' => Auth::user()->id, 'is_checked' => 0, 'is_notify' => 0 ]);
        $total_ = Message::where([ 'to' => Auth::user()->id, 'is_checked' => 0 ])->count();

        $total = $chat->count();
        if($total > 0)
        {
            $notify = $chat->first()->toArray();
            Message::where([ 'to' => Auth::user()->id, 'is_checked' => 0, 'is_notify' => 0, 'id' => $notify['id'] ])->update(['is_notify' => 1]);
        }
        echo  json_encode([ 'total' => $total, 'total_chat' => $total_, 'notify' => $notify ]);
    }

    function loadEmoji()
    {
        return view('message.emoji');
    }

    function load_message_reference(Request $request)
    {
        if($request->ad_id!='')
        {
            $data = Ads::with('user', 'ad_images')->where(['id' => $request->ad_id])->first()->toArray();
            $response = [
                'image' => asset('assets/images/listings').'/'. $data['ad_images'][0]['image'],
                'title' => $data['title'],
                'price' => $data['price']
            ];
           return \Response::json($response);
        }
    }
}
