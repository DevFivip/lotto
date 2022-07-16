<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchanges extends Model
{
    use HasFactory;

    public $fillable = [
        "moneda_id",
        "change_usd",
    ];
}
