<?php

namespace App\Models\Hipismo;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HipismoBanca extends Model
{
    use HasFactory;


    public $fillable = [
        "total",
        "user_id",
        "admin_id",
        "status",
        "code",
        "fixture_race_id",
        "moneda_id",
        "apuesta_type",
        "combinacion",
        "unidades",
    ];

    public function fixtureRace()
    {
        return $this->belongsTo(FixtureRace::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
