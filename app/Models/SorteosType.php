<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorteosType extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'premio_multiplication',
        'limit_max',
        'limit_reduce'
    ];
}
