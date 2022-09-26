<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaRegisterDetail extends Model
{
    use HasFactory;
    
    public $fillable = [
        "type",
        "detalle",
        "caja_registers_id",
        "admin_id",
        "user_id",
        "moneda_id",
        "total",
        "exchange",
        "total_usdt",
    ];
}
