<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefferalCode extends Model
{
    use HasFactory;

    protected $fillable =  [
        'cus_id',
        'ref_code',
    ];
}
