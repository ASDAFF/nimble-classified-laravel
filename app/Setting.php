<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Setting extends Authenticatable
{
    use Notifiable;

    protected $table = 'setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'logo',
        'body_bg',
        'nav_bg',
        'footer_bg',
        'copy_right_text',
        'live_chat',
        'home_ads',
        'search_ads',
        'profile_ads',
        'single_ads',
        'footer_head_color',
        'footer_link_color',
        'home_adsense',
        'search_adsense',
        'profile_adsense',
        'single_adsense',
        'home_ads_p',
        'search_ads_p',
        'profile_ads_p',
        'single_ads_p',
        'currency',
        'currency_place',
        'contact_email',
        'map_listings',
        'hide_price',
        'translate',
        'facebook',
        'linkedin',
        'twitter',
        'googleplus',
        'social_links',
        'mobile_verify',
        'header_script',
        'footer_script',
        't_bg_position',
        'b_bg_position'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}