<?php

namespace App\Models\Hipismo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;
    public $fillable = [
        'name',
        'race_day',
        'status',
        'hipodromo_id'
    ];


    public function hipodromo()
    {
        return $this->belongsTo(Hipodromo::class);
    }

    public function fixtures()
    {
        return $this->hasMany(FixtureRace::class);
    }
}
