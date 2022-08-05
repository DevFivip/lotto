<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        "caja_id",
        "moneda_id",
        "detalle",
        "total",
        "type"
    ];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }
}
