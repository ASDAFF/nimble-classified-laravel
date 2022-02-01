<?php
namespace App;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;
class Paypal extends Authenticatable
{    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'paypal';

    protected $fillable = [
        'email',
        'status'
    ];
}
