<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public $fillable = [
        "schedule",
        "interval_start_utc",
        "interval_end_utc",
        "status",
    ];
}
