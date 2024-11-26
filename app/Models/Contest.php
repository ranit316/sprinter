<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Contest extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'name', 'description','price','start_date','end_date','platform_id','category_id','result_link','cta_type','cta_link','status','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at','photo'
    ];

    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id','id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
