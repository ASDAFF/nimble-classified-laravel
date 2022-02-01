<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CustomFieldData extends Model
{
    use Notifiable;
    protected $table = 'custom_field_data';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    function ads(){
        return $this->belongsTo('App\Ads');
    }
    protected $fillable = [
       //
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
