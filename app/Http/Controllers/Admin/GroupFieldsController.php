<?php

namespace App\Http\Controllers\Admin;
use App\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Category;
use App\GroupFields;

class GroupFieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$group = Groups::all();
        return view('admin.groups.list', compact('group'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::where(['status' => 1, 'parent_id' => 0])->get()->toArray();
        return view('admin.groups.create', compact('cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj = new GroupFields();

        if ($request->id != '')
        {
            $obj = $obj->findOrFail($request->id);
        }
        /* image or icon in request */

        if ($request->hasFile('image'))
        {
            $files = $request->file('image');
            $filename = $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(base_path() . '/assets/images/groups_icons/', $input['image']);
            $obj->image = $filename;
            $obj->icon = '';
        }else{
            $obj->icon = $request->icon;
            $obj->image = '';
        }
        $obj->fill($request->all());

        if ($obj->save())
        {
            $id = $obj->id;
            if ($request->id == '')
            {
                $cat = Category::parent($request->category_id)->renderAsArray();

                if(isset($cat[0]['parent_id']))
                {
                    $parent_id = $cat[0]['parent_id'];
                }else{
                    $parent_id = $request->category_id;
                }

                DB::table('category_groups')
                        ->insertGetId(['category_id' => $parent_id, 'group_id' => $request->group_id]);
                }

            return redirect('groups')->with('success','Operation Successful!')->with('id', $request->group_id);
        } else {
            return redirect('groups')->with('error','Unknown Error!');
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
        $cat = Category::where(['status' => 1, 'parent_id' => 0])->get()->toArray();
        $group = Groups::where(['id' => $id])->first();
        return view('admin.category.create', compact('cat', 'group'));
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


}
