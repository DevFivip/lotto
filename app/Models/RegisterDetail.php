<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "register_id",
        "animal_id",
        "schedule",
        "schedule_id",
        "admin_id",
        "winner",
        "monto",
        "moneda_id",
    ];


    public function animal()
    {

        return  $this->belongsTo(Animal::class, 'animal_id');
    }


    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
