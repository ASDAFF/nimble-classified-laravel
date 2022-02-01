<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    function loadCity(Request $request)
    {
        $pro =false;
        if ($request->pro == 'pro')
        {
            $pro = true;
        }
        $data = DB::table('city')->where('region_id' , $request->id)->get();
        return view('ads.load_city', compact('data', 'pro'));
    }
    function loadComune(Request $request)
    {
        $pro =false;
        if ($request->pro == 'pro')
        {
            $pro = true;
        }
        $data = DB::table('comune')->where('city_id' , $request->id)->get();
        return view('ads.load_comune', compact('data', 'pro'));
    }
}
