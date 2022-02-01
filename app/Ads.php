<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
class Ads extends Model
{
    use Notifiable;
    protected $table = 'ads';
    public function ad_images()
    {
        return $this->hasMany('App\AdsImages',  'ad_id');
    }
    // custom fields data
    public function ad_cf_data()
    {
        return $this->hasMany('App\CustomFieldData', 'ad_id');
    }
    // category
    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }
    // region
    public function region()
    {
        return $this->hasOne('App\Region', 'id', 'region_id');
    }
    // city
    public function city()
    {
        return $this->hasOne('App\City', 'id', 'city_id');
    }
    // comune
    public function comune()
    {
        return $this->hasOne('App\Comune', 'id', 'comune_id');
    }
    // user
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    // group
    public function group()
    {
        return $this->hasMany('App\GroupData', 'ad_id');
    }
    // message
    public function message()
    {
        return $this->hasMany('App\Message', 'ad_id');
    }
    // save_add
    public function save_add()
    {
        return $this->hasOne('App\SaveAdd', 'ad_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'region_id',
        'city_id',
        'comune_id',
        'zip',
        'address',
        'category_id',
        'price',
        'show_email',
        'price_option',
        'lat',
        'lng',
        'f_type'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
