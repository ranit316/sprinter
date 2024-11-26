<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description','start_date','end_date','is_feature','cta_type','cta_link','status','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at','photo'
    ];

   
}
