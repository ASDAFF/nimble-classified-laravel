<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Message;
use App\SaveAdd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\User;
use App\Ads;
use Carbon\Carbon;
use App\Region;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads_view = $this->stats('ads_view');
        $profile_view = $this->stats('profile_view');
        $register_stats = $this->stats('register');
        $message_stats = $this->messageStats();


        $total_ads = Ads::count();
        $today_ads = Ads::whereRaw('date(created_at) = curdate()')->count();
        $today_user = User::where('type', '!=', 'adm')->whereRaw('date(created_at) = curdate()')->count();
        $total_user = User::where('type', '!=', 'adm')->count();
        $total_messages = Message::count();
        $today_messages = Message::whereRaw('date(created_at) = curdate()')->count();

        $total_save_ads = SaveAdd::count();
        $today_save_ads = SaveAdd::whereRaw('date(created_at) = curdate()')->count();

        return view("admin.dashboard", compact('message_stats','total_save_ads','today_save_ads', 'today_messages','total_messages','total_ads', 'total_user', 'today_ads', 'today_user','ads_view', 'profile_view', 'register_stats'));
    }

/*stats*/
    private function stats($type)
    {
        $date = new Carbon;
        $date->subMonth(12);

        $data=array();

        for($i=1; $i<13; $i++){            
            $add_month = $date->addMonth(1);
            $month = date('m', strtotime($add_month));
            $year = date('Y', strtotime($add_month));

            if ($type == 'ads_view' || $type == 'profile_view'){                
                $table = 'profile_visit';
            }else{                
                $table = 'users';
            }
            $stats = DB::table($table);
            $stats = $stats->select(DB::raw('count(id) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'));
            $stats = $stats->whereYear('created_at', $year);
            $stats = $stats->whereMonth('created_at', $month);
            if ($type == 'ads_view' || $type == 'profile_view'){
                $stats = $stats->where([$type => 1]);                
            }else{
                $stats = $stats->where('type', '!=','adm');                
            }            
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

    /* message stats */
    private function messageStats()
    {
        $date = new Carbon;
        $date->subMonth(12);

        $data=array();

        for($i=1; $i<13; $i++){
            $add_month = $date->addMonth(1);
            $month = date('m', strtotime($add_month));
            $year = date('Y', strtotime($add_month));

            $stats = DB::table('message');
            $stats = $stats->select(DB::raw('count(id) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'));
            $stats = $stats->whereYear('created_at', $year);
            $stats = $stats->whereMonth('created_at', $month);

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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /*
     * Add Location
     * region
     * */

    function regionCreate(Request $request)
    {
        return view('admin.location.region');
    }
    // region
    function storeRegion(Request $request)
    {
        $obj = new Region();
        if ($request->id)
        {
            $obj = $obj->findOrFail($request->id);
        }
        $obj->fill($request->all());

        if ($obj->save())
        {
            echo 1;
        }
    }
    function editRegion($id)
    {
        $region = Region::where('id', $id)->first();
        return view('admin.location.region', compact('region'));
    }

/*
 * City
 * */

    // create city
    function cityCreate(Request $request)
    {
        $region = Region::all()->all();
        return view('admin.location.city', compact('region'));
    }

    // city store
    function storeCity(Request $request)
    {
        $obj = new City();
        if ($request->id)
        {
            $obj = $obj->findOrFail($request->id);
        }
        $obj->fill($request->all());

        if ($obj->save())
        {
            echo 1;
        }
    }
    // edit city
    function editCity($id)
    {
        $city = City::where('id', $id)->first();
        $region = Region::all();

        return view('admin.location.city', compact('city', 'region'));
    }

}
