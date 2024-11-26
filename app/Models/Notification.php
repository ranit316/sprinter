<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'module', 'message','is_read','is_openabl','permissions','action','table','table_id','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at','user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

}
