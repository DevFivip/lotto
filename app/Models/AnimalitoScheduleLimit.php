<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalitoScheduleLimit extends Model
{
    use HasFactory;

    public $fillable = [
        "animal_id",
        "schedule_id",
        "limit",
    ];
}
