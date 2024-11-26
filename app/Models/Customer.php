<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'referCode',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'user_id',
        'ref_id'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function reffel()
    {
        return $this->hasOne(RefferalCode::class,'cus_id','id');
    }
}
