<?php

namespace App\Http\Controllers;

use App\AdsImages;
use App\CustomPage;
use App\Setting;
use Illuminate\Http\Request;
use App\Category;
use DB;
use App\User;
use App\Ads;
use Auth;
use Carbon\Carbon;
use Validator;
use ZipArchive;
use File;
use Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('checkInstaller');
        if (file_exists(storage_path('installed')))
        {
           // echo "yes";
           // return header("public/install");
        }else{
           // echo "no";
             header("location: public/install");
            die();
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regionAds = Ads::join('region', 'region.id', 'ads.region_id')
            ->select('region.title', 'region.id')
            ->groupBy('region.title')
            ->where('ads.status', 1)
            ->get();

        /*city wise ads*/
        $newAds = Ads::join('ads_images', 'ads_images.ad_id', 'ads.id')
            ->select('ads.id', 'ads.title', 'ads.price', 'ads_images.image')
            ->where(['ads.status' => 1])
            ->whereNull('ads.f_type')
            ->orderBy('ads.id', 'desc')
            ->limit(10)
            ->groupBy('ads.id')
            ->get();

        $home_ads = Ads::join('ads_images', 'ads_images.ad_id', 'ads.id')
            ->select('ads.id', 'ads.title', 'ads.price', 'ads_images.image')
            ->where(['ads.status' => 1, 'ads.f_type' => 'home_page_price'])
            ->orderBy('ads.id', 'desc')
            ->groupBy('ads.id')
            ->get();


        $region = DB::table('region')->get();
        //$category = Category::attr(['name' => 'category', 'style="height:48px"'=>'', 'class' => 'form-control locinput input-rel', 'id' => 'category' ])->renderAsDropdown();
        $parent_cat = Category::select('name','slug','icon', 'image')->where(['parent_id'=>0, 'status' => 1 ])->get();

        $cat = Category::all()->where('status', 1)->toArray();
        $category = array(
            'categories' => array(),
            'parent_cats' => array()
        );
        //build the array lists with data from the category table
        foreach ($cat as $row)
        {
            //creates entry into categories array with current category id ie. $categories['categories'][1]
            $category['categories'][$row['id']] = $row;
            //creates entry into parent_cats array. parent_cats array contains a list of all categories with children
            $category['parent_cats'][$row['parent_id']][] = $row['id'];
        }
        return view('home', compact('home_ads','region','category', 'parent_cat', 'newAds', 'regionAds'));
    }

    // confirm email

    function userConfirm(Request $request)
    {
        try {
            if (isset($request->user))
            {
                $msg = '';
                $temp = base64_decode($request->user);
                $temp = explode('%', $temp);
                $type = $temp[0];
                $email = $temp[1];
                $name = $temp[2];
                $where = ['type' => $type, 'email' => $email, 'name' => $name];
                $user_id = User::where($where)->value('id');

                if (!$user_id)
                {
                    return redirect('home')->with('error', 'Your account is not confirmed or already active!');
                }else{
                    $update = Ads::where(['user_id' => $user_id, 'status' => 4])->update(['status' => 0]);
                    if ($update)
                    {
                        $msg = '<p> Your inactive ads are under review now.</p><p>Log in to continue.</p>';
                    }
                    User::where($where)->update(['email_verify' => 1 ]);
                    return redirect('home')->with('success', 'Your account is activated'.$msg)->with('email', $email);
                }
            }
        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    // is user login crone
    function is_login()
    {
        $update = User::where('login_update', '<', Carbon::now()->subMinutes(2)->toDateTimeString())->update(['is_login' => 0]);
        if ($update)
        {
            $ads = Ads::where('user_id' , Auth::user()->id)->update(['is_login' => 0 ]);
        }
    }


    function updateVersion(Request $request)
    {
       return view('admin.update.index');
    }

    // get server url
    function getServerURL()
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $filePath = $_SERVER['REQUEST_URI'];
        $withInstall = substr($filePath,0,strrpos($filePath,'/')+1);
        $serverPath = $serverName.$withInstall;
        $applicationPath = $serverPath;

        if (strpos($applicationPath,'http://www.')===false)
        {
            if (strpos($applicationPath,'www.')===false)
                $applicationPath = 'www.'.$applicationPath;
            if (strpos($applicationPath,'http://')===false)
                $applicationPath = 'http://'.$applicationPath;
        }

//$url = $applicationPath.'uploads/';

        return $applicationPath;
    }

    // server
    function update(Request $request)
    {
        try {

            ini_set('max_execution_time', '9000000');

            $old_ver = DB::table('setting')->value('version');

            if (!isset($_GET['ver'])) {
                $ver = $old_ver;
            } else
                $ver = $_GET['ver'];
            $url = $this->getServerURL();
            $time = time();
            /* echo '<body style="border: 1px solid #fff; width: 600px; height: 100px; margin: 100px auto;">
             <img src="'.asset('assets/images/loader1.gif').'" style="float: left; margin-top: 20; margin-right: 20px"><h2>Please wait....</h2><hr></body>';*/
            $json = file_get_contents("http://apps.ranksol.com/app_updates/classified_app/update.php?url=$url&ver=$ver&time=$time");

            ///////////////log mysql file
            if (isset($_GET['log']) && $_GET['log'] == "true") {
                echo "<b>Json recieved</b>" . $json . "<b>Version---$old_ver</b><hr>";
            }
            $arr = json_decode($json, true);
            if ($arr['error'] == "no") {
                if (is_array($arr['sql']) && count($arr['sql']) > 0) {
                    //  print_r($arr['sql']);
                    // die();

                    foreach ($arr['sql'] as $key => $val) {

                        $file = @file_get_contents("http://apps.ranksol.com/app_updates/classified_app/sql/$val?time=$time");
                        $queryArray = array();
                        $queryArray = explode(';', $file);
                        for ($i = 0; $i < count($queryArray); $i++)
                            if (trim($queryArray[$i]) != '')
                                //mysql_query($queryArray[$i]);
                                DB::statement($queryArray[$i]);

                        ///////////////log mysql file
                        if (isset($_GET['log']) && $_GET['log'] == "true") {
                            echo "<b>My sql contents------</b>" . $file . "------<hr>";
                        }
                        ////////////////////end log
                    }
                }
///echo "http://woottext.com/wbsms_updates/update/$arr[zip]";
                if (strlen($arr['zip']) > 3) {
                    file_put_contents($arr['zip'], file_get_contents("http://apps.ranksol.com/app_updates/classified_app/update/$arr[zip]?time=$time"));
                    if (class_exists('ZipArchive')) {
                        //$dir=dirname(__FILE__);
                        $dir = getcwd();
                        $zip = new ZipArchive;
                        $res = $zip->open("$arr[zip]");
                        if ($res === TRUE) {
                            // echo 'ok';
                            $zip->extractTo("$dir/");
                            $zip->close();
                            ///////////////////log zip
                            if (isset($_GET['log']) && $_GET['log'] == "true") {
                                echo "<b>Zip------</b>" . $arr['zip'] . "------<hr>";
                            }
                            ///////////////////end log zip/////////////////
                        } else {
                            echo 'failed, code:' . $res;
                        }
                    } else {
                        include_once(getcwd() . '/pclzip.lib.php');
                        $archive = new PclZip($arr['zip']);
                        $v_list = $archive->extract();

                        if ($v_list == 0) {
                            die("Error : " . $archive->errorInfo(true));
                        }
                        ///////////////////log zip lib
                        if (isset($_GET['log']) && $_GET['log'] == "true") {
                            echo "<b>Zip lib------</b>" . $arr['zip'] . "------<hr>";
                        }
                        ///////////////////end log zip/////////////////
                    }
                    //@unlink($arr['zip']);
                }
                if (is_array($arr['del']) && count($arr['del']) > 0) {
                    foreach ($arr['del'] as $val_d) {
                        @unlink($val_d);
                        ///////////////////log unlink
                        if (isset($_GET['log']) && $_GET['log'] == "true") {
                            echo "<b>unlink------</b>" . $val_d . "------<hr>";
                        }
                        ///////////////////end log unlink/////////////////
                    }
                }
                if (isset($arr['version']) && $arr['version'] != "") {
                    $sql = Setting::where('id', 1)->update(['version' => $arr['version']]);
                    //echo "<h2>".$_SESSION['message'] =  "Application has been Updated Successfully";
                    @unlink(getcwd() . '/' . $arr['zip']);
                }
            }
            if (!isset($_GET['log'])) {
                return response()->json(['success' => 1]);
            }
        }catch (\Exception $e){
            return response()->json(['success' => $e->getMessage()]);
        }
    }


    function test(Request $request){
        $Data = ['data' => $request->all()];

        Mail::send( 'test.index', $Data, function($msg){
            $msg->subject('Redirect url');
            $msg->to('adnang7274@gmail.com');
            $msg->from('info@gmail.com');
        });
        exit;
    }


    function saveContactForm(Request $request){

        try {

            $validation_rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'subject' => 'required|string',
                'message' => 'required',
            ];

            $valid = Validator::make($request->all(), $validation_rules);

            if ($valid->fails()) {
                return back()->withErrors($valid)->withInput();
            } else {

                $email = DB::table('setting')->value('contact_email');
                $subject = $request->subject;

                $message = '<strong>Hi, Admin</strong> <br><br> ';
                $message .= '<strong> User Name: </strong>' . $request->first_name . ' ' . $request->last_name . '<br> ';
                $message .= '<strong>User Email:</strong> ' . $request->email . '<br>  ';
                $message .= '<strong>Message:</strong> <br>' . $request->message;
                $data = ['content' => $message];

                Mail::send('emails.mail', $data, function ($msg) use ($email, $subject) {
                    $msg->subject($subject);
                    $msg->to($email);
                });

            }
        }catch (\Exception $e){
            $err = $e->getMessage();
        }

        if(isset($err)){
            return back()->with('error', $err);
        }else{
            return back()->with('success', 'Message send successfully.');
        }
    }

    function showCustomPages($title){
        if( $title!='' ){
            $page = CustomPage::where('slug', $title)->first();
            return view('custom_page', compact('page'));
        }else{
            return abort(404);
        }
    }

    function mapListings()
    {
        $map = Ads::select('title', 'id', 'lat', 'lng', 'description','address', 'user_id', 'price', 'price_option')
            ->where('lat', '!=', 0)
            ->where('lng', '!=', 0)
            ->get();

        $setting = DB::table('setting')->first();
        if($setting->currency_place == 'left'){$left = $setting->currency;}else{ $left = '';}
        if($setting->currency_place == 'right'){$right = $setting->currency;}else{ $right = '';}

        $marker = $price = $price_option ='';
        $count = 0;
        if(count($map)> 0) {
            foreach ($map as $value) {
                $count++;
                $image = AdsImages::select('image')->where('ad_id', $value->id)->value('image');
                if ($image) {
                    $img = asset('assets/images/listings/' . $image);
                } else {
                    $img = asset('assets/images/listings/empty.png');
                }
                if(User::where('id', $value->user_id)->value('phone')!=''){
                    $phone = $phone = User::where('id', $value->user_id)->value('phone');
                }else{
                    $phone= 'Not available!';
                }
                if($value->price_option!=''){$price_option = '/'.$value->price_option; }
               $price =  $left. number_format($value->price) .$right . $price_option;

                $marker .= '{
                "title": "' . $value->title . '",
                "lat": "' . $value->lat . '",
                "lng": "' . $value->lng . '",
                "description": "'.$this->cleanString( $value->description ).'",
                "image": "' . $img . '",
                "address": "' . $value->address . '",
                "phone": "' .$phone . '",
                "price": "' .$price . '",
                "href": "' . url('single/' . urlencode(strtolower(str_slug($value->title . '-' . $value->id, '-')))) . '"
                },';
            }
        }else{
            $marker.='{
             "lat": "51.509865",
             "lng": "-0.118092",
             "title": "example title",
             "description": "Lorem Ipsum is a group of text that people commonly use as filler text, or dummy text. It\'s basically a bunch of mumbo-jumbo (at least that\'s what it looks like) that",
             "image": "' . asset('assets/images/listings/empty.png').'",
             "address": "Example address",
             "phone": "123456",
             "price": "$12",
             "href": "#"
             },';
        }
        $marker = rtrim($marker, ',');
        return view('map.index', compact('marker'));
    }

    private function cleanString($string)
    {
        // allow only letters
        $res = preg_replace("/[^a-zA-Z ]/", "", $string);
        // trim what's left to 8 chars
        $res = substr($res, 0, 100);
        // make lowercase
        $res = strtolower($res);
        // return
        return $res;
    }

    function verifyAd(Request $request){

        if (!empty($_SERVER['HTTP_REFERER'])) {
            echo $_SERVER['HTTP_REFERER'];
        }

        if($request->cm !='' && $request->st =='Completed' ){
            $payment_data = DB::table('payment_data')->where(['id' => $request->cm, 'status' => 3 ])->first();

            if($payment_data){
                if($payment_data->ad_data!=''){
                    $ad_data = explode('%',$payment_data->ad_data);
                    if(isset($ad_data[1])){
                        $ad_id = $ad_data[1];
                        /* update status to paid */
                        $update_ad = Ads::where(['id' => $ad_id])->update(['status' => 1]);
                        if($update_ad){
                            DB::table('payment_data')->where(['id' => $request->cm])->update(['response' => json_encode($request->all()), 'status' => 1]);
                            return redirect('/')->with('success', 'Ad posted successfully');
                        }
                    }
                }
            }else{
                return redirect('/')->with('error', 'Ad is not posted successfully.Some unknown error.');
            }
        }
    }
}
