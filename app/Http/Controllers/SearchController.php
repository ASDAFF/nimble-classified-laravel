<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Ads;
use App\Category;
use App\Region;
use App\CategoryCustomfields;
use Auth;

class SearchController extends Controller
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
        //echo 'asdf';
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
        $category_id = '';
        $this->keyword = $request->keyword;
        $this->price_sort = $request->price_sort;
        $this->price_range = $request->price_range;
        if (isset($request->reg)) {
            $this->region = Region::where('title', str_replace('-', ' ', $request->reg))->value('id');
        } else if (isset($request->region)) {
            $this->region = $request->region;
        }

        if ($request->category != '' && is_numeric($request->category)) {
            $category_id = $request->category;
        } else if ($request->main_category != '') {
            //echo 'ok';
            $category_id = Category::where('slug', urldecode($request->main_category) )->value('id');
        }

        $cat = Category::parent($category_id)->renderAsArray();
        $child_ids = Category::childIds($cat);
        array_push($child_ids, $category_id);

        $this->category = $child_ids;

        // custom search
        $totalCf = 0;
        $cf_req_array = array();
        if (is_array($request->custom_search)) {
            $where = '';
            foreach ($request->custom_search as $index => $item) {
                if ($index != '' && $item != '') {
                    $this->custom_search = true;
                    $where .= 'custom_field_data.column_name = "' . $index . '" and custom_field_data.column_value = "' . $item . '" OR ';
                    $totalCf++;
                    array_push($cf_req_array, $item);
                }
            }
            $this->where = rtrim(ltrim($where), 'OR ');
        }

//exit;
        $sql_search = Ads::with(array('region' => function ($query) {
                if ($this->region != '') {
                    $query->where('region.id', $this->region);
                }
            }, 'category' => function ($query) {
                $query->whereIn('categories.id', $this->category);
            }
            , 'save_add' => function ($query) {
                    if (!Auth::guest()) {
                        $query->where('save_add.user_id', Auth::user()->id);
                    }
                }
            , 'ad_cf_data' => function ($query) {

                    $query->join('customfields', 'customfields.id', '=', 'custom_field_data.cf_id');
                    $query->where('is_shown', 1);
                    if ($this->custom_search == true) {
                        $query->whereRaw($this->where);
                    }
                },
                'ad_images', 'city', 'user'
            )
        );

        if ($this->region != '') {
            $sql_search = $sql_search->where('region_id', $this->region);
        }

        if ($this->category != '') {
            $sql_search = $sql_search->whereIn('category_id', $child_ids);
        }
        // keyword
        if ($request->keyword != '') {
            $sql_search = $sql_search->where('title', 'LIKE', $request->keyword . '%');
        }
        // is image
        if ($request->image != '') {
            $sql_search = $sql_search->where('is_img', $request->image);
        }
        // price sort
        if ($request->price_sort != '') {
            $sql_search = $sql_search->orderBy('price', $request->price_sort);
        }
        // price range
        if ($request->price_range != '') {
            $p_range = explode(';', $request->price_range);
            $sql_search = $sql_search->whereBetween('price', [$p_range[0], $p_range[1]]);
        }

        if ($request->online == 1 && $request->offline != 2) {
            $sql_search = $sql_search->where('is_login', 1);
        } elseif ($request->online == 2 && $request->offline != 1) {
            $sql_search = $sql_search->where('is_login', 0);
        }
        $sql_search = $sql_search->where('status',1);
        $sql_search = $sql_search->orderByRaw("FIELD(f_type , 'top_page_price', 'urgent_top_price', 'urgent_price','home_page_price', '') ASC");
        $total = $sql_search->count();

        $sql_search = $sql_search
            ->paginate(10)
            ->appends(request()
                ->query());
//        print_r($sql_search);
//
//        exit;
        error_reporting(0);
        if($total > 0){

        if (isset($sql_search) && count($sql_search[0]->category) > 0 && count($sql_search[0]->city) > 0 && count($sql_search[0]->region) > 0) {

            if ($this->custom_search == true) {
                if (count($sql_search[0]->ad_cf_data) < 1) {
                    $result = array();
                }

            } else {
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
        $req_category = $category_id;

        return view('search.index', compact('search_fields','result', 'total', 'region', 'category', 'req_category'));
    }

    function ajaxSearch(Request $request){
        $where = '';
        foreach($request->all() as $index => $item){
            $where .= 'column_name = "'.$index.'" and column_value = "'.$item.'" OR ';
        }
        echo  $result = rtrim($where, 'OR ');
    }

}
