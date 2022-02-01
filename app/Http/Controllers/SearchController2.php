<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Ads;
use App\Category;
use App\Region;
use App\CategoryCustomfields;

class SearchController2 extends Controller
{

    private $where , $category , $region, $price_range, $price_sort, $keyword = '';
    private $custom_search = false;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        echo 'asdf';
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

    public function search(Request $request)
    {
        //print_r($request->all());
        //exit;
        $result = array();
        $this->region = $request->region;
        $this->keyword = $request->keyword;
        $this->price_sort = $request->price_sort;
        $this->price_range = $request->price_range;

        if ($request->category != '')
        {
            $cat = Category::parent($request->category)->renderAsArray();
            $child_ids = Category::childIds($cat);
            array_push($child_ids, $request->category);
        }

        $this->category = $child_ids;

        // custom search
        if(is_array($request->custom_search))
        {
            $where = '';
            foreach($request->custom_search as $index => $item){
                if($index!='' && $item!='')
                {
                    $this->custom_search = true;
                    $where .= 'custom_field_data.column_name = "'.$index.'" and custom_field_data.column_value = "'.$item.'" OR ';
                }
            }
             $this->where = rtrim($where, 'OR ');
        }
//exit;
        $sql_search = Ads::with(array('region' => function ($query)
            {
                if($this->region!='')
                {
                    $query->where('region.id', $this->region);
                }
            }, 'category' => function ($query)
            {
                $query->whereIn('categories.id', $this->category);
            }
            , 'ad_cf_data' => function ($query)
                {
                    //$query->whereRaw($this->where);
                    //$query->where('custom_field_data.ad_id', 6);
                    $query->join('customfields', 'customfields.id', '=', 'custom_field_data.cf_id');
                    $query->where('is_shown', 1);
                    if($this->custom_search == true)
                    {
                        $query->whereRaw($this->where);
                    }
                },
                'ad_images', 'city'
            )
        );

        if ($this->category != '')
        {
            $sql_search = $sql_search->whereIn('category_id', $child_ids);
        }
        // keyword
        if ($request->keyword != '')
        {
            $sql_search = $sql_search->where('title', 'LIKE', $request->keyword . '%');
        }
        // price sort
        if ($request->price_sort != '')
        {
            $sql_search = $sql_search->orderBy('price', $request->price_sort);
        }
        // price range
        if ($request->price_range != '')
        {
            $p_range = explode(';', $request->price_range);
            $sql_search = $sql_search->whereBetween('price', [$p_range[0], $p_range[1]]);
        }
        $sql_search = $sql_search->where('status', 1);
        $total = $sql_search->count();
        if ($total > 0)
        {
        $sql_search = $sql_search
            ->paginate(3)
            ->appends(request()
                ->query());

        if (isset($sql_search) && count($sql_search[0]->category) > 0 && count($sql_search[0]->city) > 0 && count($sql_search[0]->region) > 0 )
        {

            if($this->custom_search == true && count($sql_search[0]->ad_cf_data) < 1)
            {
                $result = array();
                $total = 0;
            }else{
                $result = $sql_search;
            }
        }
    }
        $category = $request->category;
        //extra search
        $search_fields = DB::table('customfields')
            ->join('category_customfields','customfields.id', 'customfields_id')
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

        // sidebar category
        $sidebar_cat = DB::table('categories')
            ->join('ads', 'ads.category_id', 'categories.id')
            ->select(DB::raw('count(ads.id) as total, categories.name'))
            ->where('categories.parent_id', 0)
            ->groupBy('categories.name')->get();
        // regions
        $region = Region::all();
        // get search fields

        // category
        //$select_category = Category::attr(['name' => 'category', 'class' => 'form-control lselect', 'id' => 'category'])->renderAsDropdown();
        $cat = Category::all()->where('status', 1)->toArray();
        $category = array(
            'categories' => array(),
            'parent_cats' => array()
        );
        //build the array lists with data from the category table
        foreach ($cat as $row) {
            //creates entry into categories array with current category id ie. $categories['categories'][1]
            $category['categories'][$row['id']] = $row;
            //creates entry into parent_cats array. parent_cats array contains a list of all categories with children
            $category['parent_cats'][$row['parent_id']][] = $row['id'];
        }
        return view('search.index', compact('search_fields','result', 'total', 'sidebar_cat', 'region', 'category'));
    }

    function ajaxSearch(Request $request){
        $where = '';
        foreach($request->all() as $index => $item){
            $where .= 'column_name = "'.$index.'" and column_value = "'.$item.'" OR ';
        }
        echo  $result = rtrim($where, 'OR ');
    }

}
