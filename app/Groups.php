<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{

    protected $table = 'groups';

    public function groupFields(){
        return $this->hasMany('App\GroupFields', 'group_id');
    }
    public function groupCat(){
        return $this->hasOne('App\Category', 'id','category_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','icon','category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}