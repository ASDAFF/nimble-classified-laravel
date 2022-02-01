<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class CustomPage extends Authenticatable
{
    use Notifiable;
    protected $table = 'custom_page';
    protected $fillable = [ 'title', 'contents', 'slug' ];
    protected $hidden = [];
}
