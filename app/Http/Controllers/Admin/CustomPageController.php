<?php

namespace App\Http\Controllers\Admin;

use App\CustomPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class CustomPageController extends Controller
{

    public function index()
    {
        return view("admin.custom_page.index");
    }

    function store(Request $request){
        $title = $request->title;
        if($title!=''){
            /* check unique title */
            $obj = new CustomPage();

            if( $request->id!=''){
                if (CustomPage::where('title', $title)->where('id', '!=', $request->id)->exists()) {
                    return response()->json(['msg' => 3]);
                }
                $obj = $obj->findOrFail($request->id);
            }else{
                if (CustomPage::where('title', $title)->exists()) {
                    return response()->json(['msg' => 3]);
                }
            }

            $obj->fill($request->all());
            $obj->slug = str_replace(' ', '-', trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $title)) );

            if($obj->save()){
                return response()->json(['msg' => 1]);
            }else{
                return response()->json(['msg' => 2]);
            }
        }
    }

    function create(){
        $page = CustomPage::all();
        return view("admin.custom_page.manage", compact('page'));
    }

    function edit($id){
        $page = CustomPage::findOrFail($id);
        return view("admin.custom_page.index", compact('page'));
    }

    function show($id){
      //
    }

    function sortPages(Request $request){

        if(count($request->itemOrder)>0){
            foreach ($request->itemOrder as $i => $value){
                CustomPage::where('id', $value)->update(['sort' => $i]);
            }
        }
    }
}