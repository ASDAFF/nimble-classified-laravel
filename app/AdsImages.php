<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class AdsImages extends Model
{
    public function ads()
    {
        return $this->belongsToMany('App\Ads');
    }
}
