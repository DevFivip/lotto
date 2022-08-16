<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        "admin_id",
        "moneda_id",
        "type",
        "detalle",
        "total",
    ];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
