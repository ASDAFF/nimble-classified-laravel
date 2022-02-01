<?php

namespace App\Http\Controllers;

use App\Ads;
use App\Chat;
use App\FeaturedAds;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;
use DB;

class CronController extends Controller
{
     private  $notification_subject, $notification_to_email,$items = "";
    function index(){


        /* get active ads of more than 30 days   */
        $Ads = Ads::where('f_type', '')->whereIn('status', [1,4]);
            $Ads = $Ads->where('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString());
            $activeAdsIds = $Ads->pluck('id');
            $UserId = $Ads->pluck('user_id');            
            /* fetch email of user */
            $User = User::whereIn('id', $UserId)->get();
            $email_temp = DB::table('email_settings')->select('expiry_ads_subject','expiry_ads_content')->first();
            $subject = $email_temp->expiry_ads_subject;
            $content = $email_temp->expiry_ads_content;

        if( count( $activeAdsIds ) > 0 ){
           /*  update ads to inactive ---  */

            foreach ($User as $value) {
                # code...
            $content = str_replace('%email%',$value->email, $content);
            $content = str_replace('%name%',$value->name, $content);

            $this->notification_to_email = $value->email;
            $this->notification_subject =  $subject;

            $data = array('content' => $content);

            Mail::send('admin.user.email_notification', $data, function($msg){
                $msg->subject($this->notification_subject);
                $msg->to($this->notification_to_email);
            });
            } 

            $now = DB::raw('NOW()');
           /*  update ads to inactive ---  */
            Ads::whereIn('id', $activeAdsIds)
                ->update([ 'status' => 2, 'created_at' => $now ]);
        }
        /* featured ads */

        $featured_settings = FeaturedAds::select('home_page_days', 'top_page_days', 'urgent_top_days', 'top_page_days', 'urgent_days', 'urgent_top_days')->first()->toArray();
        $activeAds = [];
        if( isset($featured_settings) ){
            foreach ($featured_settings as $index => $setting){
                $Ads = Ads::where('f_type', str_replace('_days', '_price', $index))->where('status', 1);
                $Ads = $Ads->where('created_at', '<=', Carbon::now()->subDays($setting)->toDateTimeString());
                $activeAds[] = $Ads->pluck('id')->toArray();
            }
        }
        $ads_ids = [];
        if(count($activeAds) > 0){
            foreach ($activeAds as $ids){
                foreach ($ids as $v){
                    $ads_ids[] = $v;
                }
            }
        }

        $now = DB::raw('NOW()');
        /*  update ads to inactive --- */
        Ads::whereIn('id', $ads_ids)
            ->update([ 'status' => 2, 'created_at' => $now ]);
    }
}