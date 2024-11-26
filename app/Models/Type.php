<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = ['name',
    'description',
    'status',
    'created_by',
    'updated_by',
    'deleted_by',
    'created_at',
    'updated_at'];
}
