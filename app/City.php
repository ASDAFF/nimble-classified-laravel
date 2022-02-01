<?php
namespace App;
  use Illuminate\Database\Eloquent\Model;
  class City extends Model  {
  protected $table = 'city';
  /**  * The attributes that are mass assignable.
  *  * @var array  */
  protected $fillable = [  'title', 'region_id'  ];
  /**  * The attributes that should be hidden for arrays.
  *  * @var array  */  protected $hidden = [];
  }
