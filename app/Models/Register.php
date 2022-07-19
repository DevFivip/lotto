<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'caja_id',
        'user_id',
        'admin_id',
        'total',
        'moneda_id',
        'has_winner',
    ];
}
