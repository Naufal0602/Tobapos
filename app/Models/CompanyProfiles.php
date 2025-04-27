<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfiles extends Model
{
    protected $fillable = [
        'name',
        'address',
        'about_description',
        'home_description',
        'img_description',
        'img_home',
        'phone',
        'email',
    ];

    
}
