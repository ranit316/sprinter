<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description','category_id','status','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at','type_id'
    ];

   
    public function category(){
        return $this->belongsTo(FaqCategory::class,'category_id','id');
    }


    public function type()
    {

        return $this->belongsTo(Type::class,'type_id','id');
    }
}
