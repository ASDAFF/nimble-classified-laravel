<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
 class Customfields extends Model {
	 public function categories() {
		return $this->belongsToMany('App\Category') ->withTimestamps();
	 }
	protected $fillable = [ 'inscription', 'description', 'data_type', 'is_shown' ];
   }
