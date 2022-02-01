<?php

namespace App\Http\Controllers;
use App\FeaturedAds;
use App\PaymentGateway;
use Cartalyst\Stripe\Stripe;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Category;
use App\Ads;
use App\User;

use App\CustomFieldData;
use App\GroupData;
use Session;
use DB;
use Auth;
use Validator;

use Mail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\URL;

class AdsController extends Controller
{
    use AuthenticatesUsers;

    protected $file_path = '/assets/images/listings/';
    private  $category , $region, $notification_subject, $notification_to_email = '';
    private $custom_search = false;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        error_reporting(0);
    }

    public function index()
    {
        if(!Auth::guest()) {
            if(Auth::user()->type =='adm'){
                return view('admin.ads.list');
            }else{
                return back();
            }
        }else{
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $region = DB::table('region')->get();
        $parent_cat = Category::select('name','slug','icon', 'image')->where('parent_id',0)->get();

        $featured = FeaturedAds::first();

        return view('ads.create', compact('region', 'parent_cat', 'featured'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_guest=$is_edit=$isAdminAd=$featured_success=$is_paypal = false;
        try {
            /* featured add payment */
            if($request->ad_price!=0 && $request->ad_price == $request->featured_amount)
            {
                $validator = Validator::make($request->all(), [
                    'card_no' => 'required',
                    'ccExpiryMonth' => 'required',
                    'ccExpiryYear' => 'required',
                    'cvvNumber' => 'required',
                    //'amount' => 'required',
                ]);

                if ($validator->passes()) {
                    $api_key = PaymentGateway::select('*')->first();
                    $stripe = Stripe::make($api_key->stripe_secret_key);
                    $token = $stripe->tokens()->create([
                        'card' => [
                            'number' => $request->get('card_no'),
                            'exp_month' => $request->get('ccExpiryMonth'),
                            'exp_year' => $request->get('ccExpiryYear'),
                            'cvc' => $request->get('cvvNumber'),
                        ],
                    ]);

                    if (!isset($token['id'])) {
                        return response()->json(['msg' => 'error']);
                        exit;
                    }
                    $charge = $stripe->charges()->create([
                        'card' => $token['id'],
                        'currency' => 'USD',
                        'amount' => $request->ad_price,
                        'description' => 'Add in wallet',
                    ]);

                    if($charge['status'] = 'succeeded') {
                        $featured_success = true;
                    } else {
                        return response()->json(['msg' => 'error_f']);
                        exit;
                    }
                }else{
                    return response()->json(['msg' => 'fill_required']);
                    exit;
                }
            }

            $obj = new Ads();
            if ($request->id != '')
            {
                $obj = $obj->findOrFail($request->id);
                $obj->title = str_replace('-',"", $request->title);
                $is_edit = true;
            }else{
              if(isset($request->paypal) && $request->paypal=='yes'){
                $is_paypal = true;
                  $obj->status = 3;
              }else{
                  $obj->status = 0;
              }
            }

            $obj->fill($request->all());

            if (!Auth::guest())
            {
                if (Auth::user()->type == 'adm')
                {
                    if ($is_edit)
                    {
                        $user_id = $request->user_id;
                    }else{
                        $user_id = Auth::user()->id;
                    }

                    $obj->status = 1;
                    if ($user_id == Auth::user()->id)
                    {
                        $isAdminAd = true;
                    }
                    if(Auth::user()->phone==''){
                        if($request->phone!=''){
                            User::where('id', auth::user()->id)->update(['phone' => $request->phone]);
                        }
                    }
                }else{
                    $user_id = Auth::user()->id;
                    $obj->user_id = $user_id;
                }
                User::where( 'id', Auth::user()->id )->update( ['phone' => $request->phone] );
            }else{
                $is_guest = true;

                $temp_password = 'temp_'.rand(1,999);

                $user_data = [
                    'phone' => $request->phone,
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                    'password' => bcrypt($temp_password),
                    'plain_password' => $temp_password,
                    'type' => 'u',
                    'created_at' => DB::raw('NOW()')
                ];

                if(session()->has('mobile_vfy')){
                    $user_data = $user_data + array('mobile_verify' => 1 );
                }
                $user_id = User::insertGetId($user_data);
                User::where('id', $user_id)->update( ['phone' => $request->phone] );
                $email_temp = DB::table('email_settings')->select('registration_subject','registration_content')->first();
                //print_r($email_temp);
                $subject = $email_temp->registration_subject;
                $content = $email_temp->registration_content;

                $content = str_replace('%email%', $request->user_email, $content);
                $content = str_replace('%name%', $request->user_name, $content);
                $content = str_replace('%password%', $temp_password, $content);
                $content = str_replace('%status%', 'Guest User', $content);

                $this->notification_to_email = $request->user_email;
                $this->notification_subject = $subject;

                $url = base64_encode('u'.'%'.$request->user_email.'%'.$request->user_name);
                $link = url('confirm/query?user='.str_replace('=', '', $url));
                $data = array('link' => $link ,'name' => $request->user_name, 'content' => $content, 'subject' => $subject );

                Mail::send('emails.notification', $data, function($msg){
                    $msg->subject($this->notification_subject);
                    $msg->to($this->notification_to_email);
                });
                if(!$is_paypal){
                  $obj->status = 4; // guest add
                }
            }
            $obj->user_id = $user_id;
            if ($request->image_ids != '')
            {
                $obj->is_img = 1;
            }
            if ($obj->save())
            {
                $ad_id = $obj->id;
                $type='';
                // delete old data of cf
                CustomFieldData::where('ad_id', $request->id)->delete();
                // delete old data of groupd
                GroupData::where('ad_id', $request->id)->delete();
                // images

                if ($request->image_ids != '')
                {
                    $unique = '';
                    $img_raw = explode(',', $request->image_ids);
                    // get images ids
                    if ($request->deleted_ids != '')
                    {
                        $remove_images = explode(',', $request->deleted_ids);
                        $unique = array_diff($img_raw, $remove_images);
                    }
                    if (!is_array($unique))
                    {
                        $unique = explode(',', $request->image_ids);
                    }
                    // db code here
                    DB::table('ads_images')->whereIn('id', $unique)->update(['ad_id' => $ad_id]);
                }
                // cf data
                if (is_array($request->cf))
                {
                    //print_r($request->cf);
                    foreach ($request->cf as $index => $value)
                    {
                        $key =  key($value);
                        // check if data is file
                        if (is_object($value[$key]))
                        {
                            $file_name = $input[$index] = time() . '.' . $value[$key]->getClientOriginalExtension();
                            $value[$key]->move(base_path() . '/assets/images/cf_image/', $input[$index]);
                            $type = $value[$key]->getClientOriginalExtension();
                            $value[$key] = $file_name;
                        }
                        $id = DB::table('custom_field_data')
                            ->insertGetId(
                                [
                                    'ad_id' => $ad_id,
                                    'column_name' => $index,
                                    'column_value' => $value[$key],
                                    'type' => $type,
                                    'cf_id' => $key
                                ]
                            );
                    }
                }
                // Group data
                if (is_array($request->group))
                {
                    //print_r($request->cf);
                    foreach ($request->group as $i => $val)
                    {
                        $key =  key($val);
                        $temp = explode('#', $i);
                        $id = DB::table('group_data')
                            ->insertGetId(
                                [
                                    'ad_id' => $ad_id,
                                    'column_name' => $temp[0],
                                    'column_value' => $val[$key],
                                    'group_id' => $key,
                                    'group_field_id' => $temp[1]
                                ]
                            );
                    }
                }
            }
        }catch(\Exception $e){
            $err = $e->getMessage();
        }

        if (isset($err))
        {
            return response()->json(['msg' => 2, 'error' => $err]);
        }else{
            if ($isAdminAd)
            {
                return response()->json(['msg' => 'admin_ad']);

            }else {
                if ($is_guest)
                {
                    if(isset($request->paypal) && $request->paypal=='yes'){
                        $payment_id = DB::table('payment_data')->insertGetId(['ad_data' =>  time().'%'.$ad_id ]);
                        return response()->json(['msg' => 4, 'ad_id' => $payment_id]);
                    }else{
                        return response()->json(['msg' => 4]);
                    }
                } else {
                    if(isset($request->paypal) && $request->paypal=='yes'){
                        $payment_id = DB::table('payment_data')->insertGetId(['ad_data' =>  time().'%'.$ad_id ]);
                        return response()->json(['msg' => 1, 'ad_id' => $payment_id]);
                    }else{
                        return response()->json(['msg' => 1]);
                    }
                }
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guest())
        {
            return back()->with('error', 'Unauthorised!');
            exit;
        }

        $region = DB::table('region')->get();
        $parent_cat = Category::select('name','slug','icon', 'image')->where('parent_id',0)->get();
        // ad data
        $id = Ads::whereId($id )->value('id');
        //$ad_id = User::where();
        if ($id)
        {
            $ad_data = Ads::with('ad_images', 'category', 'city')
                ->where('id', $id)
                ->first()->toArray();
            //groups data
            $groups = array();
            $grup = DB::table('group_data')
                ->join('groups', 'group_data.group_id', 'groups.id')
                ->select(
                    'groups.id as group_id',
                    'groups.title',
                    'groups.icon',
                    'groups.image'
                )
                ->where('group_data.ad_id', $id)
                ->groupBy('group_data.group_id')
                ->get()->toArray();

            foreach ($grup as $v)
            {
                $group_fields = DB::table('group_fields')
                    ->join('group_data', 'group_data.group_id', 'group_fields.group_id')
                    ->select(
                        'group_fields.title',
                        'group_fields.icon',
                        'group_fields.image',
                        'group_fields.id',
                        'group_data.column_name',
                        'group_data.column_value'
                    )
                    ->where(['group_data.ad_id' => $id, 'group_data.group_id' => $v->group_id, 'group_fields.status' => 1])
                    ->groupBy('group_fields.id')
                    ->get()
                    ->toArray();
                array_push($groups, [
                    'group_title' => $v->title,
                    'group_id' => $v->group_id,
                    'group_icon' => $v->icon,
                    'group_image' => $v->image,
                    'group_fields' => $group_fields,
                ]);
            }
        }
        return view('ads.create', compact('parent_cat', 'region', 'ad_data', 'groups'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function loadCategory(Request $request)
    {
        $id = $request->id;
        $categories = Category::parent($id)->renderAsArray();

        return view('ads.load_categories', compact('categories'));
    }
    public function uploadImages(Request $request)
    {
        if(is_array($_FILES)) {

            $file = $_FILES['image']['tmp_name'][0];
            $sourceProperties = getimagesize($file);
            $fileNewName = time().'_'.$_FILES['image']['name'][0];
            $folderPath = base_path() . $this->file_path;
            $ext = pathinfo($_FILES['image']['name'][0], PATHINFO_EXTENSION);

            $imageType = $sourceProperties[2];

            switch ($imageType) {

                case IMAGETYPE_PNG:
                    $imageResourceId = imagecreatefrompng($file);
                    $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                    imagepng($targetLayer,$folderPath. $fileNewName);
                    break;

                case IMAGETYPE_GIF:
                    $imageResourceId = imagecreatefromgif($file);
                    $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                    imagegif($targetLayer,$folderPath. $fileNewName);
                    break;

                case IMAGETYPE_JPEG:
                    $imageResourceId = imagecreatefromjpeg($file);
                    $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                    imagejpeg($targetLayer,$folderPath. $fileNewName);
                    break;

                default:
                    echo "Invalid Image type.";
                    exit;
                    break;
            }

            echo $insert_id = DB::table('ads_images')->insertGetId(['orignal_filename' => $_FILES['image']['name'][0], 'image' => $fileNewName]);
        }

    }

    private function imageResize($imageResourceId,$width,$height) {
        $targetWidth =672;
        $targetHeight =503;
        $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
        imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
        return $targetLayer;
    }

    /*
     * delete image
    */
    public function deleteImages(Request $request)
    {

        $file = DB::table('ads_images')->select('image', 'id')->where('orignal_filename', '=', $request->file)->first();
        if ($file->image)
        {
            if (file_exists(base_path('assets/images/listings/' . $file->image)))
            {
                unlink(base_path('assets/images/listings/' . $file->image));
                $del = DB::table('ads_images')->where('image', $file->image)->delete();
                if ($del)
                {
                    echo $file->id;
                }
            }
        }
    }// end

    function singleAd(Request $request)
    {
        try {
            $slug = \Request::segment(2);
            $raw_id = explode('-', $slug);
            $raw_id = end($raw_id);
            $user = Ads::where(['id' => $raw_id])->first();
            $id = $user->id;
            $user_id = $user->user_id;
            $user_ip =  $request->ip();

            if ($id)
            {
                //increment of a visits
                Ads::where(['id' => $id])->increment('visit');
                $data = Ads::with('ad_images', 'user', 'category', 'city')
                    ->where('id', $id)
                    ->first();

                $ad_cf_data = DB::table('custom_field_data')
                    ->join('customfields', 'customfields.id', 'custom_field_data.cf_id')
                    ->select('customfields.type as type', 'customfields.inscription', 'customfields.type','customfields.icon','customfields.image', 'custom_field_data.column_name', 'custom_field_data.column_value', 'custom_field_data.type as img')
                    ->where(['custom_field_data.ad_id' => $id])
                    ->get()
                    ->toArray();

                $groups = array();
                $grup = DB::table('group_data')
                    ->join('groups', 'group_data.group_id', 'groups.id')
                    ->select(
                        'groups.id as group_id',
                        'groups.title',
                        'groups.icon',
                        'groups.image'
                    )
                    ->where('group_data.ad_id',$id)
                    ->groupBy('group_data.group_id')
                    ->get()->toArray();

                foreach($grup as $v)
                {
                    $group_fields = DB::table('group_fields')
                        ->join('group_data', 'group_data.group_field_id', 'group_fields.id')
                        ->select(
                            'group_fields.title',
                            'group_fields.icon',
                            'group_fields.image',
                            'group_fields.id',
                            'group_data.column_name',
                            'group_data.column_value'
                        )
                        ->where([ 'group_data.ad_id' => $id , 'group_data.group_id' => $v->group_id, 'group_fields.status' => 1])
                        ->get()
                        ->toArray();
                    array_push( $groups,  [
                        'group_title' => $v->title,
                        'group_id' => $v->group_id,
                        'group_icon' => $v->icon,
                        'group_image' => $v->image,
                        'group_fields' => $group_fields,
                    ]);
                }
                /// ad to stats

                DB::table('profile_visit')->insert(['ads_view' => 1, 'ip' => $user_ip, 'user_id' => $user->user_id ]);
                return view('ads.single', compact('data', 'groups', 'ad_cf_data', 'user_ip'));
            }else{
                return  back()->with('error', 'Add not found!');
            }

        }catch(\Exception $e)
        {
            $err =  $e->getMessage();
        }
        if (isset($err))
        {
            return  back()->with('error', 'Add not found!');
        }

    }
    public function userAds(Request $request)
    {
        if (\Request::segment(2) !="")
        {

            $user_id = \Request::segment(2);
            $check = User::whereId($user_id)->value('id');
            if (!$check)
            {
                return redirect()->back(); exit;
            }
            $result = array();
            $sql_search = Ads::with(array('ad_cf_data' => function ($query)
                {
                    $query->join('customfields', 'customfields.id', '=', 'custom_field_data.cf_id');
                    $query->where('is_shown', 1);
                },
                    'ad_images', 'city', 'category', 'region','user'
                )
            )->where('user_id', $user_id);

            $sql_search = $sql_search->where('status', 1);
            $total = $sql_search->count();
            if ($total > 0)
            {
                $sql_search = $sql_search
                    ->paginate(10)
                    ->appends(request()
                        ->query());

                if (isset($sql_search) && count($sql_search[0]->category) > 0 && count($sql_search[0]->city) > 0 && count($sql_search[0]->region) > 0)
                {

                    if ($this->custom_search == true && count($sql_search[0]->ad_cf_data) < 1)
                    {
                        $result = array();
                        $total = 0;
                    } else {
                        $result = $sql_search;
                    }
                }
            }
            $category = $request->category;
            //extra search
            $search_fields = DB::table('customfields')
                ->join('category_customfields', 'customfields.id', 'customfields_id')
                ->where(
                    [
                        'category_customfields.category_id' => $category,
                        'customfields.search' => 1
                    ]
                )
                ->select(
                    'customfields.name',
                    'customfields.options'
                )
                ->get()->toArray();

            // $user = User::whereId(Auth::user()->id)->first();

            // ad to stats

            $ip = $_SERVER['REMOTE_ADDR'];
            DB::table('profile_visit')->insert(['profile_view' => 1, 'ip' => $ip, 'user_id' => $user_id]);

            return view('user.user_ads', compact('search_fields', 'result', 'total'));
        }
    }

    function checkEmail(Request $request)
    {

        $email = User::where(['email' => $request->email])->value('email');
        if ($email)
        {
            echo $email;
        }else{
            echo 2;
        }
    }

    function userLogin(Request $request)
    {

        $auth = false;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember')))
        {
            $auth = true; // Success
        }

        if ($auth == true)
        {
            return response()->json([
                'auth' => $auth,
                'intended' => URL::previous(),
                'msg'=>1,
                'name' =>  Auth::user()->name,
                'phone' => Auth::user()->phone
            ]);

        } else {
            return response()->json(['msg' => 2]);
            //redirect again to login view with some errors line 3
        }
    }

    function adSuccess($id)
    {
        return view( 'user.ad_success', compact('id')  );
    }
}
