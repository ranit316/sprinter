<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description','demo_user_id','demo_password','demo_details','status','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at','photo'
    ];
}
