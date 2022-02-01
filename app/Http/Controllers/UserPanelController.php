<?php

namespace App\Http\Controllers;

use App\Ads;
use App\City;
use App\Region;
use App\Setting;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use DB;
use App\User;
use Auth;
use Illuminate\Support\Facades\Mail;

class UserPanelController extends Controller
{
    private  $email_subject, $email_to = "";

    public function index()
    {
        $ads_view = $this->stats('ads_view');
        $profile_view = $this->stats('profile_view');


        $city = $comune = '';
        $user = User::where(['id' => Auth::user()->id])->first();

        if($user->city_id!='')
        {
            $city = City::whereId($user->city_id)->first();
        }
        if($user->comune_id!='')
        {
            $comune = DB::table('comune')->whereId($user->comune_id)->first();
        }

        $region = Region::all();
        $total_visits = Ads::where(['user_id' => Auth::user()->id])->sum('visit');
        return view("user.dashboard", compact('user', 'total_visits', 'region', 'city', 'comune', 'ads_view', 'profile_view'));
    }

    private function stats($type)
        {
        $date = new Carbon;
        $date->subMonth(12);

        $data=array();

        for($i=1; $i<13; $i++){
            $add_month = $date->addMonth(1);
            $month = date('m', strtotime($add_month));
            $year = date('Y', strtotime($add_month));

            $stats = DB::table('profile_visit');
            $stats = $stats->select(DB::raw('count(id) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'));
            $stats = $stats->whereYear('created_at', $year);
            $stats = $stats->whereMonth('created_at', $month);

            $stats = $stats->where([$type => 1, 'user_id' => auth::user()->id]);

            $stats = $stats->groupby('year', 'month');
            $stats = $stats->get();
            if(count($stats)>0){
                $data[] = $stats[0]->total;
            }else{
                $data[] = 0;
            }
        }

        $data = implode(',', $data);

        if (strlen($data) > 0)
        {
            $data = $data;
        }else{
            $data = '0,0,0,0,0,0,0,0,0,0,0,0';
        }
        return $data;
    }


    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        //
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

    // profile setting
    function UserprofileSetting(Request $request)
    {
        /* if mobile verified is enabled then check user updating mobile? */
        if(Setting::value('mobile_verify') == 1) {
            if(Auth::user()->phone != $request->phone){
                return response()->json(['msg' => 3]);
            }
        }
        /* validate image*/
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,bmp,png'
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 2, 'error'=> $validator->errors()->all()]);
        }

        $is_file = false;
        $old_file = Auth::user()->image;

        $user =   User::find(Auth::user()->id);
        if($user)
        {
            if ($request->hasFile('image'))
            {
                $is_file = true;
                $file_name = $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(base_path() . '/assets/images/users/', $input['image']);
                $update_data = array( 'region_id' => $request->region_id, 'city_id' => $request->city_id, 'comune_id' => $request->comune_id, 'telephone' => $request->telephone,'vat' => $request->vat, 'fax' => $request->fax, 'address' => $request->address, 'phone' => $request->phone,'zip' => $request->zip, 'name' => $request->name, 'image' => $file_name);
            }else{
                $file_name = $old_file;
                $update_data = array( 'region_id' => $request->region_id, 'city_id' => $request->city_id, 'comune_id' => $request->comune_id, 'telephone' => $request->telephone, 'vat' => $request->vat, 'fax' => $request->fax, 'address' => $request->address, 'phone' => $request->phone,'zip' => $request->zip, 'name' => $request->name);
            }

            $update = DB::table('users')
                ->where('id', Auth::user()->id)
                ->update( $update_data );

            if($update)
            {
                // Delete old image
                if($is_file)
                {
                    if (file_exists(base_path('assets/images/users/' . $old_file)) && $old_file != null )
                    {
                        unlink(base_path('assets/images/users/' . $old_file));
                    }
                }
                return response()->json(['msg' => 1, 'file_name'=> $file_name]);
            }else{
                return response()->json(['msg' => 2]);
            }
        }
    }

    // change password
    function changePassword(Request $request)
    {
        //print_r($request->all());
        $is_old = User::where([ 'id' => Auth::user()->id, 'plain_password' => ($request->old) ])->value('id');
        if(!$is_old)
        {
            echo 2;
            die();
        }else{
            // not confirm
            if($request->new != $request->cpass)
            {
                echo 3;
            }else{
                $update = User::where([ 'id' => Auth::user()->id, 'plain_password' => ($request->old) ])
                    ->update(['plain_password' => $request->new, 'password' => bcrypt($request->new)]);
                if($update)
                {
                    echo 1;
                }
            }
        }
    }

    // my ads
    function myAds()
    {
        return view('user.my_ads');
    }
    // pending approaval ads
    function pendingAds()
    {
        return view('user.pending_ads');
    }
    // pending active ads
    function activeAds()
    {
        return view('user.active_ads');
    }
    // pending inactive ads
    function inactiveAds()
    {
        return view('user.inactive_ads');
    }

     // pending inactive ads
    function saveAds()
    {
        return view('user.save_ads');
    }

    function userIdCard(Request $request)
    {
        if ($request->hasFile('image'))
        {
            $validator = Validator::make($request->all(), [
                'image.*' => 'required|mimes:jpeg,bmp,png'
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => 2, 'error'=> $validator->errors()->all()]);
            }
            $f_name = '';
            $files = $request->file('image');
            foreach ($files as $file)
            {
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $up = $file->move(base_path() . '/assets/images/users/id_card/', $file_name);
                $f_name.=$file_name.',';
            }
            if($up)
            {
                User::whereId(Auth::user()->id)->update(['id_card' => rtrim($f_name, ','), 'is_verified' => 1]); // 1 for process
                return response()->json(['msg' => 1]);
            }
        }
    }
    // contact user

    function contactUser(Request $request)
    {

        $to_user = User::whereId($request->id)->first();
        $to = $to_user->id;
        $message = $request->msg;
        $ad_id = $request->ad_id;
        // chat
        $identifier = Auth::user()->id . ':' . $to;
        $from = Auth::user()->id;
        $insert = DB::table('message')->insertGetId(['identifier' => $identifier, 'text' => $message, 'from' => $from, 'to' => $to, 'ad_id' => $ad_id]);
        if ($insert)
        {

        //------------------
        $this->email_subject = 'Contact User';
        $this->email_to = $to_user->email;

        $data = array('to' => $to_user->name, 'user_message' => $message);

        Mail::send('emails.contact_user', $data, function ($msg)
        {
            $msg->subject($this->email_subject);
            $msg->to($this->email_to);
        });
        echo 1;
    }
    }

    // update status
    function login_status()
    {
        $user = User::whereId(Auth::user()->id)->update(['login_update' => Carbon::now(), 'is_login' => 1 ]);
        $ads = Ads::where('user_id' , Auth::user()->id)->update(['is_login' => 1 ]);
    }

}// end class
