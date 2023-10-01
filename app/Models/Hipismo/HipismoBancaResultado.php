<?php

namespace App\Models\Hipismo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HipismoBancaResultado extends Model
{
    use HasFactory;

    public $fillable = [
        "admin_id",
        "fixture_race_id",
        "apuesta_type",
        "combinacion",
        "win",
    ];

    static function createOrUpdate($data): void
    {
        if (isset($data['id'])) {
            //?update
            $horse = self::find($data['id']);
            $horse->fixture_race_id = $data['horse_number'];
            $horse->apuesta_type = $data['horse_name'];
            $horse->combinacion = $data['jockey_name'];
            $horse->win = $data['place'];
            $horse->update();
        } else {
            //? create
            self::create([
                "fixture_race_id" => $data["horse_number"],
                "apuesta_type" => $data["horse_name"],
                "combinacion" => $data["jockey_name"],
                // "status" => $data["status"],
                "win" => $data["fixture_race_id"]
            ]);
        }
    }
}
