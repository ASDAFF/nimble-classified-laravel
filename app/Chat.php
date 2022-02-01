<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Chat extends Authenticatable
{
    use Notifiable;

    protected $table = 'chat';

    // user
    public function userFrom()
    {
        return $this->hasOne('App\User', 'id', 'from');
    }

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
