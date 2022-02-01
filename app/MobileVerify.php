<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class MobileVerify extends Model
{
    protected $table = 'mobile_verify';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'twilio_sid', 'twilio_token','twilio_status', 'twilio_number'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
