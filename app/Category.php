<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Nestable\NestableTrait;

class Category extends \Eloquent
{

    use NestableTrait;

    protected $parent = 'parent_id';

    static function childIds($cat){
        $child_ids = array();
        array_walk_recursive($cat, function($value, $key) use(&$child_ids) {
            if($key == 'id') {
                array_push($child_ids, $value);
            }

        });
        return $child_ids;
    }

    public static function buildCategory($parent, $category) {
        $html = "";
        if (isset($category['parent_cats'][$parent])) {
            $html .= "";
            foreach ($category['parent_cats'][$parent] as $cat_id) {
                if (!isset($category['parent_cats'][$cat_id])) {
                    $html .= "<option> " .ucfirst($category['categories'][$cat_id]['name']). "</option>";
                }
                if (isset($category['parent_cats'][$cat_id])) {
                    $html .= "<optgroup label='" . ucfirst($category['categories'][$cat_id]['name']) . "'>";
                    $html .= buildCategory($cat_id, $category);
                    $html .= "</optgroup>";
                }
            }
            $html .= "";
        }
        $html .='';
        return $html;
    }
}