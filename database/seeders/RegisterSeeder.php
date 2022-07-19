<?php

namespace Database\Seeders;

use App\Models\Caja;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\Schedule;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $caja = Caja::create([
            "user_id" => 1,
            "fecha_apertura" => new DateTime(),
            "status" => 1
        ]);


        for ($i = 0; $i < 20; $i++) {

            $total = rand(1, 50);
            $candida_animalitos = rand(1, 12);

            $registro = Register::create([
                'code' => Str::random(10),
                'caja_id' => $caja->id,
                'user_id' => 1,
                'admin_id' => 1,
                'total' => $total,
                'moneda_id' => rand(1, 5),
                'status' => 1,
            ]);

            for ($k = 0; $k < $candida_animalitos; $k++) {

                $horario = Schedule::find(rand(1, 11));
                RegisterDetail::create([
                    'register_id' => $registro->id,
                    'animal_id' => rand(1, 38),
                    'schedule_id' => $horario->id,
                    'schedule' => $horario->schedule,
                    'admin_id' => 1,
                    'monto' => floatval($total) / floatval($candida_animalitos),
                    'moneda_id' => $registro->moneda_id,
                ]);
            }
        }
    }
}
