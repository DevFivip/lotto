<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnimalitoSchedule extends Model
{
    use HasFactory;

    protected $table = 'user_animalito_schedule_limits';

    protected $fillable = [
        'user_id',
        'animal_id',
        'schedule_id',
        'limit',
    ];
}
