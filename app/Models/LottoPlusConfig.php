<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LottoPlusConfig extends Model
{
    use HasFactory;

    public $fillable = [
        "porcent_comision",
        "porcent_cash",
        "porcent_limit"
    ];
}
