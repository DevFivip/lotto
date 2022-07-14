<?php

namespace Database\Seeders;

use App\Models\Moneda;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        User::create([
            'name' => 'Adolfo Gabazutt',
            'email' => 'adolfo.gbztt@gmail.com',
            'password' => bcrypt('adolfo2403'),
            'role_id' => 1,
            'status' => 1,
        ]);


        Moneda::create([
            'nombre' => 'Bolivares',
            'currency' => 'VEN',
            'simbolo' => 'Bs.',
        ]);

        Moneda::create([
            'nombre' => 'Peso Colombiano',
            'currency' => 'COP',
            'simbolo' => '$',
        ]);

        Moneda::create([
            'nombre' => 'Dolar Ecuatoriano',
            'currency' => 'ECU',
            'simbolo' => '$',
        ]);

        Moneda::create([
            'nombre' => 'Sol Peruano',
            'currency' => 'PEN',
            'simbolo' => 'S/',
        ]);

        Moneda::create([
            'nombre' => 'Binance',
            'currency' => 'BIN',
            'simbolo' => 'USDT',
        ]);
    }
}
