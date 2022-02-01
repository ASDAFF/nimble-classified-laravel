<?php
namespace App;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;
class PaymentGateway extends Authenticatable
{    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'payment_gatway';

    protected $fillable = [
        'stripe_publishable_key',
        'stripe_secret_key',
        'stripe_status',
        'paypal_email',
        'paypal_status'
    ];
}
