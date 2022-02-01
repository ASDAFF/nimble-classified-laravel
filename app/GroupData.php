<?php


namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class GroupData extends Model
{
    use Notifiable;

    protected $table = 'group_data';
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
