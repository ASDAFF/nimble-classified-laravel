<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedAds extends Model
{
    protected $table = 'featured_ads';

    protected $fillable = [
        'title',
        'description',
        'normal_listing_price',
        'home_page_price',
        'home_page_days',
        'top_page_price',
        'top_page_days',
        'urgent_price',
        'urgent_days',
        'urgent_top_price',
        'urgent_top_days',
        'status',
    ];
}
