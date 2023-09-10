<?php

namespace App\Models\Hipismo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HipismoRemate extends Model
{
    use HasFactory;

    public $fillable = [
        "code",
        "admin_id",
        "user_id",
        "fixture_race_id",
        "horse_id",
        "moneda_id",
        "monto",
        "cliente",
        "status",
    ];

    public function horse()
    {
        return $this->belongsTo(FixtureRaceHorse::class);
    }

    static function createOrUpdate($data, $uuid)
    {

        if (isset($data['code'])) {
            //?update
            // dd($data);
            $horse = self::where(['code' => $data['code'], 'id' => $data['id']])->first();
            $horse->moneda_id = $data['moneda_id'];
            $horse->cliente = $data['cliente'];
            $horse->monto = $data['monto'];
            $horse->update();
        } else {
            $auth = Auth::user();

            $horse = self::create([
                "code" => $uuid,
                "admin_id" => $auth["parent_id"],
                "user_id" => $auth["id"],
                "fixture_race_id" => $data["fixture_race_id"],
                "horse_id" => $data["id"],
                "moneda_id" => 1,
                "monto" => isset($data["monto"]) ? $data["monto"] : 0,
                "cliente" => isset($data["cliente"]) ? $data["cliente"] : null,
            ]);
        }
        return true;
    }
}
