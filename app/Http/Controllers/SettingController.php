<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Setting::find(1);
        return view('admin.setting.adsense', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Setting::find(1);
        return view('admin.setting.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validate favicon
        if ($request->hasFile('favicon')) {
            $validator = \Validator::make($request->all(), [
                "favicon" => "dimensions:max_width=32,max_height=32",
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }
        }

        /* set theme in env file */
        $theme = env('THEME');
        $path = base_path('.env');
        if(isset($theme)){
            /* check if theme change request */
            if($theme != $request->theme){
                if (file_exists($path)) {
                    file_put_contents($path, str_replace(
                        'THEME='.$theme, 'THEME='.$request->theme, file_get_contents($path)
                    ));
                }
            }
        }else{
            file_put_contents($path, PHP_EOL.'THEME='.$request->theme, FILE_APPEND | LOCK_EX);
        }

        $obj = new Setting();

        if($request->id!='')
        {
            $obj = $obj->findOrFail($request->id);
            $setting = Setting::select('logo', 'favicon', 't_bg_img', 'b_bg_img')->first();
        }

        $obj->fill($request->all());
        if (!$request->has('live_chat')) {
            $obj->live_chat = 0;
        }
        if (!$request->has('map_listings'))  {
            $obj->map_listings = 0;
        }
        if (!$request->has('translate'))  {
            $obj->translate = 0;
        }
        if (!$request->has('hide_price'))  {
            $obj->hide_price = 0;
        }
        if (!$request->has('social_links'))  {
            $obj->social_links = 0;
        }
        if (!$request->has('mobile_verify'))  {
            $obj->mobile_verify = 0;
        }

        // image
        if ($request->hasFile('logo'))
        {
            if($setting->logo!=''){
                $this->deleteOldImage('/assets/images/logo/', $setting->logo);
            }

            $file_name  = time() . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(base_path() . '/assets/images/logo/', $file_name);
            $obj->logo = $file_name;
        }

        // favicon
        if ($request->hasFile('favicon'))
        {
            if($setting->favicon!=''){
                $this->deleteOldImage('/assets/ico/', $setting->favicon);
            }

            $file_name  = time() . '.' . $request->favicon->getClientOriginalExtension();
            $request->favicon->move(base_path() . '/assets/ico/', $file_name);
            $obj->favicon = $file_name;
        }

        // t_bg_img
        if ($request->hasFile('t_bg_img'))
        {
            if($setting->t_bg_img!=''){
                $this->deleteOldImage('/assets/images/bg/', $setting->t_bg_img);
            }
            $file_name  = time() . '.' . $request->t_bg_img->getClientOriginalExtension();
            $request->t_bg_img->move(base_path() . '/assets/images/bg/', $file_name);
            $obj->t_bg_img = $file_name;
        }
        // t_bg_img
        if ($request->hasFile('b_bg_img'))
        {
            if($setting->b_bg_img!=''){
                $this->deleteOldImage('/assets/images/bg/', $setting->b_bg_img);
            }
            $file_name  = time() .uniqid(). '.' . $request->b_bg_img->getClientOriginalExtension();
            $request->b_bg_img->move(base_path() . '/assets/images/bg/', $file_name);
            $obj->b_bg_img = $file_name;
        }

        if($obj->save())
        {
            return back()->with('success', 'Settings saved successfully!');
        }else{
            return back()->with('error', 'Unknown error!');
        }
    }

    function deleteOldImage($path, $img){
        if (file_exists(base_path($path . $img)) && $img != null )
        {
            @unlink(base_path($path . $img));
        }
    }



    function adsenseStore(Request $request)
    {

        //print_r($request->all());

        $obj = new Setting();

        if($request->id!='')
        {
            $obj = $obj->findOrFail($request->id);
        }

        $obj->fill($request->all());

        if (!$request->has('home_ads'))
        {
            $obj->home_ads = 0;
        }

        if (!$request->has('search_ads'))
        {
            $obj->search_ads = 0;
        }

        if (!$request->has('profile_ads'))
        {
            $obj->profile_ads = 0;
        }

        if (!$request->has('single_ads'))
        {
            $obj->single_ads = 0;
        }

        if($obj->save())
        {
            return back()->with('success', 'Settings saved successfully!');
        }else{
            return back()->with('error', 'Unknown error!');
        }
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
    function themeCss(Request $request){
        if(isset($request->css) && !empty($request->css) ){
            $css = str_replace('preset', '', $request->css);
            $update = Setting::whereId(1)->update(['theme_css'=> $css]);
            if($update){
                return response()->json(['msg' => 1]);
            }else{
                return response()->json(['msg' => 2]);
            }
        }else{
            return response()->json(['msg' => 2]);
        }
    }
}