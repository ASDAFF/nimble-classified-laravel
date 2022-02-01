<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Customfields;
use App\Category;

class CustomfieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_tree = Category::nested()->get();
        $customfields = Customfields::all()->toArray();
        $customfield_new = array();

        //print_r($customfields);

        //if (is_array($customfields) && count($customfields) > 0 ) {

            for ($i = 0; $i < count($customfields); $i++)
            {
                $customfield_categories = DB::table('category_customfields')
                    ->where('customfields_id', $customfields[$i]['id'])
                    ->get()
                    ->toArray();
                $customfield_categories_array = array();
                if (is_array($customfield_categories) && count($customfield_categories))
                {
                    for ($j = 0; $j < count($customfield_categories); $j++)
                    {
                        array_push($customfield_categories_array, $customfield_categories[$j]->category_id);
                    }
                }
                $customfields[$i]['associated_categories'] = $customfield_categories_array;
            }


               for ($i = 0; $i < count($customfields); $i++)
               {
                if (is_array($customfields[$i]['associated_categories']) && count($customfields[$i]['associated_categories']))
                {

                    $customfields[$i]['cat_tree_html'] = $this->prepareCategoriesTree($categories_tree, $customfields[$i]['associated_categories']);

                } else {
                    $customfields[$i]['cat_tree_html'] = $this->prepareCategoriesTree($categories_tree, array());


                }
            }
            //return view('admin.custom_fields.list', compact('customfields'));
        //}else{

            $customfield_new['cat_tree_html'] = $this->prepareCategoriesTree($categories_tree, array());
            return view('admin.custom_fields.list', compact('customfield_new', 'customfields'));
        //}


        //print_r($customfield_new);

    }

    /**
     * Store an instance of the resource
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        try {
            $is_edit = false;

            $cfObj = new Customfields();
            if ($request->cf_id !='')
            {
                $cfObj = $cfObj->findOrFail($request->cf_id);
                $is_edit = true;
            }

            if ($is_edit)
            {
                // delete old categories
                $del = DB::table('category_customfields')->where(['customfields_id' => $request->cf_id])->delete();
            }
            $cfObj->fill($request->all());
            if ($request->hasFile('image'))
            {
                $filename = $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(base_path() . '/assets/images/c_icons/', $input['image']);
                $cfObj->image = $filename;
                $cfObj->icon = '';
            }else{
                if ($request->icon!='')
                {
                    $cfObj->icon = $request->icon;
                    $cfObj->image = '';
                }
            }
            //exit;
            $cfObj->name = $request->name;
            $cfObj->type = $request->type;
            $cfObj->options = $request->options;
            $cfObj->description = $request->description;
            $cfObj->required_field = $request->required_field;
            $cfObj->search = $request->search;
            if ($request->is_shown=='')
            {
                $cfObj->is_shown = 0;
            }

            $cfObj->save();

            $relations_to_add = array();
            $categories_selected = $request->categories;

            for ($i = 0; $i < count($categories_selected); $i++)
            {
                if (!$cfObj->categories->contains($categories_selected[$i]))
                {
                    array_push($relations_to_add, $categories_selected[$i]);
                }
            }
                $cfObj->categories()->attach($relations_to_add);

            return redirect('customfields')->with('success','Operation Successful!');
        } catch (Exception $e)
        {
            //echo('Showing error: ' . $e->getMessage());
            return redirect('customfields')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove Custom Field by ID.
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function removeCustomField(Request $request)
    {
        try {
            $cfield_id = $request->input('id');
            DB::table('category_customfields')->where('customfields_id', '=', $cfield_id)->delete();
            $customfield = Customfields::find($cfield_id);
            $customfield->delete();
            return response()->json(['deleted' => 1]);
        } catch (Exception $e)
        {
            echo('Showing error: ' . $e->getMessage());
        }
    }

    /* public function newCField()
    {
        $html = '
            <div class="portlet">
                <div class="portlet-heading portlet-default">
                    <h3 class="portlet-title text-dark">New Custom Field</h3>
                    <div class="portlet-widgets">
                        <a data-toggle="collapse" data-parent="#accordion1" href="#bg_default"><i class="ion-edit"></i></a>
                        <span class="divider"></span>
                        <a title="Delete Custom Field" href="javascript:void(0)" class="delete-cfield" data-id=""><i class="ion-close-round"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="bg_default" class="panel-collapse collapse">
                    <div class="portlet-body">
                    	<form name="form" action="#" method="post">
                    		{{ csrf_field() }}
                    		<fieldset>
                    			<h5>Update custom field</h5>
                    			<div class="form-group">
                    				<input id="cf_id" name="cf_id" type="hidden" value="" class="form-control" />
                    			</div>
                    			<div class="form-group">
                    				<label for="name">Field Name:</label>
                    				<input id="name" name="name" type="text" value="" class="form-control" />
                    			</div>
                    			<div class="form-group">
                    				<label for="type">Field Type:</label>
                    				<select name="type" class="form-control">
                    					<option value="text">TEXT</option>
                    					<option value="textarea">TEXT AREA</option>
                    					<option value="dropdown">DROPDOWN</option>
                    					<option value="radio">RADIO</option>
                    					<option value="checkbox">CHECKBOX</option>
                    					<option value="url">URL</option>
                    					<option value="date">DATE</option>
                    					<option value="dateinterval">DATE INTERVAL</option>
                    					<option value="file">FILE</option>
                    				</select>
                    			</div>
                    			<div class="form-group">
                    				<label for="options">Field Options:</label>
                    				<input id="options" name="options" type="text" value="" class="form-control" />
                    				<span class="help-block">Enter Comma-separated options.</span>
                    			</div>
                    			<div class="checkbox checkbox-success">
                    				<input name="required_field" type="checkbox" value="1">
                    				<label>This field is mandatory</label>
                    			</div>
                    		</fieldset>
                    		<h5>Select the categories where you want to apply the attribute:</h5>
                    		<div id="tree" class="tree-view">
								{!! $customfield['cat_tree_html'] !!}
                            </div>
                            <br />
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="reset" class="btn btn-default">Cancel</button>
                    	</form>
                    </div>
                </div>
            </div>
        ';
    } */

    /**
     * Recursive operation to resolved nested categories.
     * @param array $category
     */
    private function prepareCategoriesTree($category, $asso_cate, $categories_html = '')
    {
        $categories_html .= '<ul>';
        for ($i = 0; $i < count($category); $i++)
        {
            $li_start = '<li>';
            if (is_array($category[$i]['child']) && count($category[$i]['child']))
            {
                $li_start = '<li class="collapsed">';
            }
            $categories_html .= $li_start;
            $categories_html .= '<input name="categories[]" type="checkbox" value="' . $category[$i]['id'] . '"';
            if (in_array($category[$i]['id'], $asso_cate))
            {
                $categories_html .= ' checked="checked" /><span>' . $category[$i]['name'] . '</span>';
            } else {
                $categories_html .= ' /><span>' . $category[$i]['name'] . '</span>';
            }
            if (is_array($category[$i]['child']) && count($category[$i]['child']))
            {
                $categories_html = $this->prepareCategoriesTree($category[$i]['child'], $asso_cate, $categories_html);
            }
            $categories_html .= '</li>';
        }
        $categories_html .= '</ul>';
        return $categories_html;



    }
}
