<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [

        'type', 'content','title','photo','user_name','video','status','marks','user_id','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at','review'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
   
}
