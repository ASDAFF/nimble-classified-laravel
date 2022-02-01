<?php

namespace App\Http\Controllers\Admin;
use App\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Category;
use App\CroupFields;
use Validator;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = Groups::with('groupFields', 'groupCat')
            ->orderBy('category_id', 'desc')
            ->get()
            ->toArray();
       /*print_r($groups);
        exit;*/
        return view('admin.groups.list', compact('group', 'groups'));
    }
    public function create()
    {
        $cat = Category::where(['status' => 1, 'parent_id' => 0])->get()->toArray();
        return view('admin.groups.create', compact('cat'));
    }
    public function store(Request $request)
    {
        try {
            /* validate image*/
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'mimes:jpeg,bmp,png'
            ]);
            if ($validator->fails()) {
                echo json_encode(['msg' => 2, 'error'=> $validator->errors()->all()]);
                exit;
            }

            $obj = new Groups();

            if ($request->id != '')
            {
                $obj = $obj->findOrFail($request->id);
            }
            /* image or icon in request */
            if ($request->hasFile('image'))
            {
                $filename = $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(base_path() . '/assets/images/groups_icons/', $input['image']);
                $obj->image = $filename;
                $obj->icon = '';
            } else {
                $obj->icon = $request->icon;
                $obj->image = '';
            }
            $obj->fill($request->all());
            if ($obj->save())
            {
                $id = $obj->id;
                echo json_encode(['msg' => 'success', 'id' => $id]);
            } else {
                echo json_encode(['msg' => 'err']);
            }
        }catch(\Exception $e)
        {
            $err = $e->getMessage();
        }
        if(isset($err))
        {
            echo json_encode(['msg' => 'err']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cat = Category::where(['status' => 1, 'parent_id' => 0])->get()->toArray();
        $group = Groups::where(['id' => $id])->first();

        return view('admin.groups.create', compact('cat', 'group'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }


}
