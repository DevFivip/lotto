<?php

namespace App\Models\Hipismo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixtureRaceHorse extends Model
{
    use HasFactory;
    public $fillable = [
        "horse_number",
        "horse_name",
        "jockey_name",
        "status",
        "fixture_race_id",
        "place",
    ];



    static function createOrUpdate($data): void
    {
        if (isset($data['id'])) {
            //?update
            $horse = self::find($data['id']);
            $horse->horse_number = $data['horse_number'];
            $horse->horse_name = $data['horse_name'];
            $horse->jockey_name = $data['jockey_name'];
            $horse->place = $data['place'];
            $horse->win = $data['win'];
            $horse->fixture_race_id = $data['fixture_race_id'];
            $horse->update();
        } else {
            //? create
            self::create([
                "horse_number" => $data["horse_number"],
                "horse_name" => $data["horse_name"],
                "jockey_name" => $data["jockey_name"],
                // "status" => $data["status"],
                "fixture_race_id" => $data["fixture_race_id"]
            ]);
        }
    }
}
