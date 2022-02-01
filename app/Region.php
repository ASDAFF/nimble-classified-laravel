<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{


    protected $table = 'region';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}