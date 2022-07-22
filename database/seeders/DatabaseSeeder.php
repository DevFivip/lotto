<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\Schedule;
use App\Models\User;
use DateTime;
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
            'taquilla_name' => 'FivipLotto',
            'name' => 'Adolfo Gabazutt',
            'email' => 'adolfo.gbztt@gmail.com',
            'password' => bcrypt('adolfo2403'),
            'role_id' => 1,
            'status' => 1,
            'parent_id' => 1,
            "monedas" => ['1', '2', '3', '4', '5']
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

        Exchange::create([
            'moneda_id' => 1,
            'change_usd' => 5.80
        ]);

        Exchange::create([
            'moneda_id' => 2,
            'change_usd' => 3.80
        ]);

        Exchange::create([
            'moneda_id' => 3,
            'change_usd' => 1.02
        ]);

        Exchange::create([
            'moneda_id' => 4,
            'change_usd' => 1993.80
        ]);

        Exchange::create([
            'moneda_id' => 5,
            'change_usd' => 1
        ]);


        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '1',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '2',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '3',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '4',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '5',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '6',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '7',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '8',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '9',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Caiman',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);
        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
        ]);

        Schedule::create([
            "schedule" => "9 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "10 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "11 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "12 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "01 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "02 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "03 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "04 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "05 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "06 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1
        ]);

        Schedule::create([
            "schedule" => "07 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1
        ]);


        // $this->call([
        //     RegisterSeeder::class
        // ]);
    }
}
