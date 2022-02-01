<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCustomfields extends Model
{
    protected $table = 'category_customfields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    // category customfields
    public function category_customfields()
    {
        return $this->hasMany('App\Customfields','id', 'customfields_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}