<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\FeaturedAds;
use App\PaymentGateway;
use App\Paypal;
use Illuminate\Http\Request;

class FeaturedAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featured_ads = FeaturedAds::first();
        $paymentGateway = PaymentGateway::first();

        return view('admin.featured_ads.index', compact('featured_ads', 'paymentGateway'));
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
        $obj = new FeaturedAds();
        if($request->id!=''){
            $obj = $obj->findOrFail($request->id);
        }
        $obj->fill($request->all());
        $status = 0;
        if($request->status){
            $status = 1;
        }
        $obj->status = $status;
        if($obj->save()){
           return response()->json(['msg' => 1, 'id' => $obj->id]);
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

    function paymentGatewaySave(Request $request){
        $obj = new PaymentGateway();
        if($request->id!=''){
            $obj = $obj->findOrFail($request->id);
        }
        $obj->fill($request->all());
        $stripe_status = 0;
        if($request->stripe_status){
            $stripe_status = 1;
        }
        $obj->stripe_status = $stripe_status;

        /* paypal status */
        $paypal_status = 0;
        if($request->paypal_status){
            $paypal_status = 1;
        }
        $obj->paypal_status = $paypal_status;

        if($obj->save()){
            return response()->json(['msg' => 1, 'id' => $obj->id]);
        }
    }
}
