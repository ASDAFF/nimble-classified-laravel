<?php

namespace App\Http\Controllers;

use App\MobileVerify;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

class MobileVerifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->type!='adm'){
            return abort(401);
        }

        $mobile_verify = MobileVerify::first();
        if($mobile_verify) {

            $sid = $mobile_verify->twilio_sid;
            $token = $mobile_verify->twilio_token;
            $url = "https://$sid:$token@api.twilio.com/2010-04-01/Accounts/$sid/IncomingPhoneNumbers";
            $ch = curl_init(); // Initialize the curl
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url); // set the opton for curl
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// set the option to transfer output from script to curl
            $response = curl_exec($ch); // Execute curl
            $response = (array)simplexml_load_string($response);
        }
        return view('admin.mobile_verify.index', compact('mobile_verify', 'response'));
    }

    /*Verify Phone Number*/


    function phoneVerifyCode(Request $request){
        /* get settings */
        $setting = MobileVerify::first();

        $sid = $setting->twilio_sid;
        $token = $setting->twilio_token;
        $from_number = $setting->twilio_number;

        if($setting) {
            $phoneNumber = $request->phone;
            $url = "https://lookups.twilio.com/v1/PhoneNumbers/$phoneNumber";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // add POST fields
            curl_setopt($ch, CURLOPT_HTTPGET,true);
            $response   =   curl_exec($ch);
            curl_close($ch);

             $response = json_decode($response);

             //print_r($response);

             if( isset( $response->phone_number)){
                 //echo '<pre>';

                 $digits = 4;
                 $code = rand(pow(10, $digits-1), pow(10, $digits)-1);

                 $data =  $this->sendMessage($sid, $token, $from_number, $response->phone_number, $code);

                    if(isset($data->SMSMessage) &&  $data->SMSMessage->Status == 'queued'){
                       /*insert code data*/
                       DB::table('mobile_code')->insert(
                           [
                               'email' => $request->email,
                               'code' => $code,
                               'phone' => $response->phone_number
                           ]
                       );

                       return response()->json(['msg' => 1, 'number' => $response->phone_number]);
                    }else if( isset( $data->RestException) ){
                       return response()->json(['msg' => 2, 'error' => (string)$data->RestException->Message[0] ]);
                    }else{
                       return response()->json(['msg' => 1, 'error' => 'unknown error!']);
                    }

             }else if( isset($response->code) ){
                 return response()->json(['msg' => 2, 'error' => str_replace('/', ' ', $response->message) ]);
             }else{
                 return response()->json(['msg' => 1, 'error' => 'unknown error!']);
             }
        }
    }
    /*send message*/
    private function sendMessage($sid, $token, $from, $to, $code){

        $url = "https://api.twilio.com/2010-04-01/Accounts/$sid/SMS/Messages";

        $body = "User this code $code to verify your phone number";
        $data = array(
            'From' => $from,
            'To' => $to,
            'Body' => $body,
        );
        $post = http_build_query($data);
        $x = curl_init($url);
        curl_setopt($x, CURLOPT_POST, true);
        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($x, CURLOPT_USERPWD, "$sid:$token");
        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
        $y = curl_exec($x);
        curl_close($x);

       return simplexml_load_string($y);
    }

    function verifyCode(Request $request){
        $data = DB::table('mobile_code')
            ->where([ 'email' => $request->email, 'phone' => $request->phone, 'code' => $request->code ])->first();
            /* update user */
            User::where( ['id' => Auth::user()->id] )->update([ 'mobile_verify' => 1 ]);

        if(isset($data)){
            Session::put('mobile_vfy', $request->email);
            return response()->json([ 'msg' => 1 ]);
        }else{
            return response()->json([ 'msg' => 2 , 'error' => 'Invalid code' ]);
        }
    }


    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        if(Auth::user()->type!='adm'){
            return abort(401);
        }

        $obj = new MobileVerify();
        if($request->id!=''){
            $obj = $obj->findOrFail($request->id);
        }
        $obj->fill($request->all());

        if($request->twilio_status){
            $obj->status = 1;
        }
        if($obj->save()){
           return back()->with('success', 'Settings saved successfully');
        }
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


}
