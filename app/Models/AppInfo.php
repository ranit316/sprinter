<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'email',
        'phone',
        'whats_app_1',
        'whats_app_2',
        'whats_app_3',
        'whats_app_4',
        'whats_app_5',
        'whats_app_6',
        'description',
        'version',
        'beta_url',
        'playstore_url',
        'appstore_url',
        'logo',
        'dark_logo',
        'fav_icon'
    ];
}
