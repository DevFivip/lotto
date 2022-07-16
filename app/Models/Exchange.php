<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    public $fillable = [
        "moneda_id",
        "change_usd",
    ];


    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }
}
