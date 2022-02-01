<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmailSettings extends Authenticatable
{
    use Notifiable;
    protected $table = 'email_settings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'registration_subject',
        'registration_content',
        'status_subject',
        'status_content',
        'verify_success_subject',
        'verify_success_content',
        'verify_danger_subject',
        'verify_danger_content',
        'expiry_ads_subject',
        'expiry_ads_content',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}