<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;
use App\Ads;
use App\Region;
use DB;

class CategoryController extends Controller
{
    /*
     * private vars
  */
    private $where , $category , $region, $price_range, $price_sort, $keyword = '';
    private $custom_search = false;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat = Category::all()->where('status', 1)->toArray();
        //print_r($category);
        $category = array(
            'categories' => array(),
            'parent_cats' => array()
        );
        //build the array lists with data from the category table
        foreach ($cat as $row)
        {
            //creates entry into categories array with current category id ie. $categories['categories'][1]
            $category['categories'][$row['id']] = $row;
            //creates entry into parent_cats array. parent_cats array contains a list of all categories with children
            $category['parent_cats'][$row['parent_id']][] = $row['id'];
        }
        //print_r($category);
        //echo $this->buildCategory(0, $category);
        return view('admin.category.list', compact('category', 'cat'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::all()->where('status', 1)->toArray();
        return view('admin.category.create', compact('cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $edit = false;
        $validation_rules = [
            'name' => 'required',
            'image' => 'mimes:jpeg,bmp,png'
        ];

        $valid = Validator::make($request->all(), $validation_rules);

        if ($valid->fails())
        {
            echo json_encode(['msg' => 'dup', 'alert' => $valid->errors()->all()]);
        } else {

            $obj = new Category();

            if ($request->id != '')
            {
                $obj = $obj->findOrFail($request->id);
                $edit = true;
            }
            // cat titile
            $name = $request->name;
            $slug = strtolower(str_replace(' ', '-', $name));

            /* image or icon in request */

            if ($request->hasFile('image'))
            {
                $files = $request->file('image');
                $filename = $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(base_path() . '/assets/images/c_icons/', $input['image']);
                $obj->image = $filename;
                $obj->icon = '';
            }else{
                $obj->icon = $request->icon;
                $obj->image = '';
            }
            //$obj->fill($request->all());
            $obj->name = $name;
            $obj->slug = $slug;
            if ($request->hide_parent == '' && $request->hide_parent != 'y')
            {
                $obj->parent_id = $request->category;
            }

            if ($obj->save())
            {
                $id = $obj->id;

                // in edit delete old price options
                //if ($edit && $request->price!=''){
               /* if ($edit){
                    $parent_id = Category::where('id', $request->id)->value('parent_id');
                    $cat = Category::parent($parent_id)->renderAsArray();
                    $child_ids = Category::childIds($cat);
                    array_push($child_ids, $parent_id);
                    // delete old
                        DB::table('price_options')->whereIn('category_id',$child_ids)->delete();
                    foreach($child_ids as $value){
                        $inset = DB::table('price_options')->insert(['category_id' => $value,'options' => $request->price]);
                    }

                } */
                                
                if ($edit)
                {
                     $inset = DB::table('price_options')->where('category_id',$id)->update(['options' => $request->price]);   //insert(['category_id' => $value,'options' => $request->price]);
                }
                
                // child ids
                /*if ($request->category!=0 && !$edit && $request->price !='') {

                    $cat = Category::parent($request->category)->renderAsArray();
                    $child_ids = Category::childIds($cat);
                    array_push($child_ids, $request->category);
                    foreach($child_ids as $value){
                        $inset = DB::table('price_options')->insert(['category_id' => $value,'options' => $request->price]);
                    }
                }else if ($request->category == 0 && !$edit && $request->price !='') {
                    $inset = DB::table('price_options')->insert(['category_id' => $id,'options' => $request->price]);
                }  */
                
                if (!$edit)
                {
                     $inset = DB::table('price_options')->insert(['category_id' => $id,'options' => $request->price]);
                }

                echo json_encode(['msg' => 'success', 'id' => $id]);
            } else {
                echo json_encode(['msg' => 'err']);
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
        $cat = Category::all()->where('status', 1)->toArray();
        $category = Category::where(['status' => 1, 'id' => $id])->first();
        $price_option = DB::table('price_options')->where('category_id', $id)->value('options');
        return view('admin.category.create', compact('cat', 'category', 'price_option'));
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

    function saleCategory($title, Request $request)
    {
        if ($title!='')
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
                $category_id = $request->category;
            }else{
                $category_id = Category::where('name', $title)->value('id');
            }

            // child ids
            $cat = Category::parent($request->category)->renderAsArray();
            $child_ids = Category::childIds($cat);
            array_push($child_ids, $request->category);

            $this->category = $child_ids;

            // custom search
            if (is_array($request->custom_search))
            {
                $where = '';
                foreach($request->custom_search as $index => $item)
                {
                    if ($index!='' && $item!='')
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
                    if ($this->region!='')
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
                        if ($this->custom_search == true)
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

                    if ($this->custom_search == true && count($sql_search[0]->ad_cf_data) < 1)
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
            foreach ($cat as $row)
            {
                //creates entry into categories array with current category id ie. $categories['categories'][1]
                $category['categories'][$row['id']] = $row;
                //creates entry into parent_cats array. parent_cats array contains a list of all categories with children
                $category['parent_cats'][$row['parent_id']][] = $row['id'];
            }
            return view('search.index', compact('search_fields','result', 'total', 'sidebar_cat', 'region', 'category'));

            }
        }


}
