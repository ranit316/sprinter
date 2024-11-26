<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms_pages extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at',
    ];
}
