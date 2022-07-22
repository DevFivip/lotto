<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        "schedule_id",
        "animal_id",
        "quantity_plays",
        "quantity_winners",
        "quantity_lossers",
        "amount_winners_usd",
        "amount_home_usd",
        "amount_balance_usd",

    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }
}
