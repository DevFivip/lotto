<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaRegister extends Model
{
    use HasFactory;

    public $fillable = [
        "admin_id",
        "user_id",
        "caja_id",
        "total_tickets_cant",
    ];

}
