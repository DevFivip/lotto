<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'caja_id',
        'user_id',
        'admin_id',
        'total',
        'moneda_id',
        'has_winner',
    ];
   
    protected $cast = [
        'code'=>"string",
        'caja_id'=>"integer",
        'user_id'=>"integer",
        'admin_id'=>"integer",
        'moneda_id'=>"integer",
        'has_winner'=>"integer",
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function detalles()
    {
        return $this->hasMany(RegisterDetail::class, 'register_id');
    }
}
