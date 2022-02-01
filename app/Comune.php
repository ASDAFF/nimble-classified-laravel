<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Comune extends Model
{
    protected $table = 'comune';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
