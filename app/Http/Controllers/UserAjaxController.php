<?php

namespace App\Http\Controllers;

use App\GroupFields;
use Illuminate\Http\Request;
use App\Category;
use App\Groups;
use App\Ads;
use DB;
use Auth;
use Yajra\Datatables\Datatables;

class UserAjaxController extends Controller
{
    // ajax show custom fields to ads post
   public function loadCustomFields(Request $request)
   {
       $cat = Category::parent($request->id)->renderAsArray();
       $cat_ids = Category::childIds($cat);
       array_push($cat_ids, $request->id);

       $fields = DB::table('category_customfields')
           ->join('customfields', 'category_customfields.customfields_id', 'customfields.id')
           ->select(
               'customfields.id',
               'customfields.name',
               'customfields.type',
               'customfields.data_type',
               'customfields.options',
               'customfields.description',
               'customfields.inscription',
               'customfields.required_field',
               'customfields.icon',
               'customfields.image'
           )
           ->whereIn('category_customfields.category_id',$cat_ids)
           ->groupBy('category_customfields.customfields_id')
           ->get();
          // ->toArray()

       // groups

       $groups = array();

        $data = DB::table('category_groups')
            ->join('groups', 'category_groups.group_id', 'groups.id')
            ->select(
                'groups.id as group_id',
                'groups.title',
                'groups.icon',
                'groups.image'
            )
            ->whereIn('category_groups.category_id',$cat_ids)
            ->groupBy('groups.id')
            ->get()->toArray();

        foreach($data as $v){
            $group_fields = GroupFields::select('title', 'icon', 'image', 'id')->where(['group_id' => $v->group_id, 'status' => 1])->get()->toArray();
            array_push( $groups,  [
                'group_title' => $v->title,
                'group_id' => $v->group_id,
                'group_icon' => $v->icon,
                'group_image' => $v->image,
                'group_fields' => $group_fields
            ]);
        }

       return view('ads.load_customfields', compact('fields', 'groups'));
   }

    function loadMyAds(Request $request)
    {

        $data = DB::table('ads')
            ->join('region', 'region.id', '=', 'ads.region_id')
            ->join('city', 'city.id', '=', 'ads.city_id')
            ->join('categories', 'categories.id', '=', 'ads.category_id')
            ->select(
                'region.id',
                'region.title as ad_title',
                'ads.title',
                'ads.price',
                'ads.description',
                'ads.status',
                'ads.id as ads_id',
                'ads.created_at',
                'region.title as region_title',
                'city.title as city_title',
                'categories.name as category_title'
            )->where('user_id', Auth::user()->id);
        $count = 0;
        return Datatables::of($data)
            ->editColumn('id', function($data){global $count;
                $count++;
                return $count;
            })
            ->editColumn('title', function($data){
                $title='';
                $title .= '<a href="'.url('single/'.urlencode(strtolower(str_slug($data->title.'-'.$data->ads_id, '-' ) ) )  ).'">'.ucfirst($data->title).'</a>';
                return $title;
            })
            ->addColumn('action', function ($data) {
                if($data->status == 0)
                {
                    $status = "fa-lock"; $title = 'Block'; $btn_clr = 'btn-danger';
                }
                if($data->status == 1)
                {
                    $status = "fa-unlock";$title = 'Active'; $btn_clr = 'btn-success';
                }
                $b = '<a onclick="deleteRow(this)" data-id="' . $data->ads_id . '" data-obj="user_ads" href="javascript:;" title="Delete" class="btn btn-sm btn-danger danger-alert"><i class="glyphicon glyphicon-trash"></i></a> ';

                return $b;
            })
            ->rawColumns(['title', 'action'])
            ->make(true);
    }
}
