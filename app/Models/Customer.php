<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $fillable = [
        "admin_id",
        "users",
        "nombre",
        "document",
        "phone",
        "email",
        "status",
    ];
}
