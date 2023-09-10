<?php

namespace App\Models\Hipismo;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixtureRace extends Model
{
    use HasFactory;

    public $fillable = [
        "race_number",
        "start_time",
        "status",
        "race_id",
        "hipodromo_id"
    ];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function hipodromo()
    {
        return $this->belongsTo(Hipodromo::class);
    }
    static function createOrUpdate($fixture): void
    {

        if (isset($fixture['id'])) {
            $find = self::where('id', $fixture['id'])->first();
            //update
            $find->race_number = $fixture['race_number'];
            $find->start_time = $fixture['start_time'];
            // $find->status = $fixture['status'];
            $find->race_id = $fixture['race_id'];
            $find->hipodromo_id = $fixture['hipodromo_id'];
            $find->update();
        } else {
    
            $newFixture = self::create([
                'race_number' => $fixture['race_number'],
                'start_time' => new DateTime($fixture['start_time']),
                'status' => 1,
                'race_id' => $fixture['race_id'],
                'hipodromo_id' => $fixture['hipodromo_id'],
            ]);
            //create
        }
    }
}
