<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\Schedule;
use App\Models\SorteosType;
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

        // User::create([
        //     'taquilla_:30name' => 'FivipLotto',
        //     ':30name' => 'Adolfo Gabazutt',
        //     'email' => 'adolfo.gbztt@gmail.com',
        //     'password' => bcrypt('adolfo2403'),
        //     'role_id' => 1,
        //     'status' => 1,
        //     'parent_id' => 1,
        //     "monedas" => ['1', '2', '3', '4', '5']
        // ]);


        // Moneda::create([
        //     'nombre' => 'Bolivares',
        //     'currency' => 'VEN',
        //     'simbolo' => 'Bs.',
        // ]);

        // Moneda::create([
        //     'nombre' => 'Peso Colombiano',
        //     'currency' => 'COP',
        //     'simbolo' => '$',
        // ]);

        // Moneda::create([
        //     'nombre' => 'Dolar Ecuatoriano',
        //     'currency' => 'ECU',
        //     'simbolo' => '$',
        // ]);

        // Moneda::create([
        //     'nombre' => 'Sol Peruano',
        //     'currency' => 'PEN',
        //     'simbolo' => 'S/',
        // ]);

        // Moneda::create([
        //     'nombre' => 'Binance',
        //     'currency' => 'BIN',
        //     'simbolo' => 'USDT',
        // ]);

        // Exchange::create([
        //     'moneda_id' => 1,
        //     'change_usd' => 5.80
        // ]);

        // Exchange::create([
        //     'moneda_id' => 2,
        //     'change_usd' => 3.80
        // ]);

        // Exchange::create([
        //     'moneda_id' => 3,
        //     'change_usd' => 1.02
        // ]);

        // Exchange::create([
        //     'moneda_id' => 4,
        //     'change_usd' => 1993.80
        // ]);

        // Exchange::create([
        //     'moneda_id' => 5,
        //     'change_usd' => 1
        // ]);

        $sorte = SorteosType::create([
            "name" => 'Lotto Activo RD'
        ]);

        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '01',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '02',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '03',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '04',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '05',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '06',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '07',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '08',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '09',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Cocodrilo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);
        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "08:30 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 12:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "09:30 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "10:30 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "11:30 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "12:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "01:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "02:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "03:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "04:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "05:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "06:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);

        Schedule::create([
            "schedule" => "07:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte->id,
        ]);





        $sorte2 = SorteosType::create([
            "name" => 'Lotto Rey'
        ]);

        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '01',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '02',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '03',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '04',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '05',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '06',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '07',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '08',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '09',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Cocodrilo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);
        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);


        Schedule::create([
            "schedule" => "09:30 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "10:30 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "11:30 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "12:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "01:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "02:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "03:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "04:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "05:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "06:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);

        Schedule::create([
            "schedule" => "07:30 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte2->id,
        ]);




        $sorte3 = SorteosType::create([
            "name" => 'Chance con Animalitos'
        ]);

        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '01',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '02',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '03',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '04',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '05',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '06',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '07',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '08',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '09',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Cocodrilo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);


        Schedule::create([
            "schedule" => "09 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "10 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "11 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "12 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "01 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "02 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "03 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "04 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "05 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "06 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);

        Schedule::create([
            "schedule" => "07 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte3->id,
        ]);



        $sorte4 = SorteosType::create([
            "name" => 'Tropi Gana'
        ]);

        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '01',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '02',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '03',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '04',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '05',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '06',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '07',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '08',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '09',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Cocodrilo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);


        Schedule::create([
            "schedule" => "09 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "10 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "11 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "12 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "01 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "03 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "04 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "05 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "06 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);

        Schedule::create([
            "schedule" => "07 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorte4->id,
        ]);



        $sorteo5 = SorteosType::create([
            "name" => 'Jungla Millonaria'
        ]);

        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '01',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '02',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '03',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '04',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '05',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '06',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '07',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '08',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '09',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Cocodrilo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);


        Schedule::create([
            "schedule" => "09 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "10 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "11 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "12 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "01 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "02 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "03 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "04 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "05 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "06 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);

        Schedule::create([
            "schedule" => "07 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo5->id,
        ]);



        $sorteo6 = SorteosType::create([
            "name" => 'Guacharo Activo'
        ]);

        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '01',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '02',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '03',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '04',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '05',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '06',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '07',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '08',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '09',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Cocodrilo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);


        Schedule::create([
            "schedule" => "09 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "10 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "11 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "12 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "01 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "02 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "03 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "04 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "05 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "06 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);

        Schedule::create([
            "schedule" => "07 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo6->id,
        ]);





        $sorteo7 = SorteosType::create([
            "name" => 'Selva Plus'
        ]);

        Animal::create([
            'number' => '00',
            'nombre' => 'Ballena',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Animal::create([
            'number' => '0',
            'nombre' => 'Delfin',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '01',
            'nombre' => 'Carnero',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '02',
            'nombre' => 'Toro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '03',
            'nombre' => 'Ciempies',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '04',
            'nombre' => 'Alacran',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '05',
            'nombre' => 'Leon',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '06',
            'nombre' => 'Rana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '07',
            'nombre' => 'Perico',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '08',
            'nombre' => 'Raton',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '09',
            'nombre' => 'Aguila',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '10',
            'nombre' => 'Tigre',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Animal::create([
            'number' => '11',
            'nombre' => 'Gato',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '12',
            'nombre' => 'Caballo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '13',
            'nombre' => 'Mono',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '14',
            'nombre' => 'Paloma',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '15',
            'nombre' => 'Zorro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '16',
            'nombre' => 'Oso',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '17',
            'nombre' => 'Pavo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '18',
            'nombre' => 'Burro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Animal::create([
            'number' => '19',
            'nombre' => 'Chivo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Animal::create([
            'number' => '20',
            'nombre' => 'Cochino',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '21',
            'nombre' => 'Gallo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '22',
            'nombre' => 'Camello',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '23',
            'nombre' => 'Cebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '24',
            'nombre' => 'Iguana',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '25',
            'nombre' => 'Gallina',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '26',
            'nombre' => 'Vaca',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '27',
            'nombre' => 'Perro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '28',
            'nombre' => 'Zamuro',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '29',
            'nombre' => 'Elefante',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Animal::create([
            'number' => '30',
            'nombre' => 'Cocodrilo',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '31',
            'nombre' => 'Lapa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '32',
            'nombre' => 'Ardilla',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '33',
            'nombre' => 'Pescado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);
        Animal::create([
            'number' => '34',
            'nombre' => 'Venado',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Animal::create([
            'number' => '35',
            'nombre' => 'Jirafa',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Animal::create([
            'number' => '36',
            'nombre' => 'Culebra',
            'limit_cant' => 100,
            'limit_price_usd' => 40,
            'status' => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);


        Schedule::create([
            "schedule" => "09 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 13:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "10 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 14:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "11 AM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 15:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "12 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 16:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "01 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 17:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "02 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 18:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "03 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 19:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "04 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 20:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "05 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 21:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "06 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 22:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);

        Schedule::create([
            "schedule" => "07 PM",
            "interval_start_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-15 23:50:01'),
            "interval_end_utc" => DateTime::createFromFormat('Y-m-!d H:i:s', '2009-02-16 00:50:00'),
            "status" => 1,
            "sorteo_type_id" => $sorteo7->id,
        ]);


        // $this->call([
        //     RegisterSeeder::class
        // ]);
    }
}
