<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailAnimalitoTry extends Model
{
    use HasFactory;
    protected $table = "fail_animalito_trys";

    protected $fillable = [
        "user_id",
        "animal_id",
        "total",
        "sorteo_type_id",
        "moneda_id",
        "horario_id",
    ];

    public function exchange()
    {
        return $this->hasOne(Exchange::class, 'moneda_id');
    }


    public function animal()
    {
        return $this->hasOne(Animal::class, 'animal_id');
    }

    public function sorteo()
    {
        return $this->hasOne(SorteosType::class, 'sorteo_type_id');
    }


    static function try($user_id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario): void
    {
        // dd($user_id, $animal_id, $monto, $sorteo_type_id, $moneda);
        self::create([
            "user_id" => $user_id,
            "animal_id" => $animal_id,
            "total" => $monto,
            "sorteo_type_id" => $sorteo_type_id,
            "moneda_id" => $moneda,
            "horario_id" => $horario,
        ]);
        // return false;
    }
}
