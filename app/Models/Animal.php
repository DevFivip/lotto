<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;


    public $fillable = [
        "number",
        "nombre",
        "limit_cant",
        "limit_price_usd",
        "status",
        "sorteo_type_id"
    ];

    public function type()
    {
        return $this->belongsTo(SorteosType::class, 'sorteo_type_id');
    }
}
