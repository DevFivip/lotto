<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "admin_id",
        "close_user_id",
        "fecha_apertura",
        "fecha_cierre",
        "balance_inicial",
        "balance_final",
        "entrada",
        "status",
        "referencia",
    ];

    protected $casts = [
        'balance_inicial' => 'array',
        'balance_final' => 'array',
        'entrada' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
