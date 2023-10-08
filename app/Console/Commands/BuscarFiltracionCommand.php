<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Libs\Telegram;
use App\Http\Libs\Wachiman;
use App\Models\Animal;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;


class BuscarFiltracionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:filtracion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca si hay una variacion en la venta para encontrar una filtracion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $telegram = new Telegram();
        $wachiman = new Wachiman();

        $telegram->sendMessage('Se esta ejecutando el Inspector');
        $telegram->sendMessage('Se esta ejecutando el Inspector');
        $created_at = date('Y-m-d');

        $loterias = [1, 2];

        foreach ($loterias as $loteria_id) {

            $s = Schedule::where('sorteo_type_id', $loteria_id)->where('status', 1)->orderBy('id', 'asc')->first();
            $schedule = $s->schedule;
            $animals = Animal::select('id', 'nombre', 'number')->where('sorteo_type_id', $loteria_id)->get();

            foreach ($animals as $animalito) {

                $number = $animalito->number;
                $jugadas = DB::select("SELECT schedule_id as horario_id, schedule, count(*) as jugadas,
                SUM(monto) AS monto_total,
                SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total ,
                DATE_FORMAT(from_unixtime(unix_timestamp(register_details.created_at) - unix_timestamp(register_details.created_at) mod 80), '%Y-%m-%d %H:%i:00') as createdAt 
                FROM register_details
                LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
                WHERE DATE(register_details.created_at) = DATE(?)
                and sorteo_type_id = ?
                and schedule = ?
                and register_details.animal_id = ?
                and register_details.moneda_id = 1
                group by createdAt", [$created_at, $created_at, $created_at, $loteria_id, $schedule, $number]);


                $data = $jugadas;

                // Inicializar el monto máximo
                $maxMonto = 0;

                // Inicializar el índice del registro seleccionado
                $selectedIndex = null;

                // Iterar sobre los registros
                foreach ($data as $index => $item) {

                    // print_r($item);
                    $createdAt = strtotime($item->createdAt);
                    if ($maxMonto == 0) {
                        $maxMonto = floatval($item->monto_total);
                    }
                    // print_r(date('i', $createdAt) . PHP_EOL);

                    // print_r($maxMonto.PHP_EOL);
                    // $maxMonto = $item->monto_total;
                    // Verificar si el minuto es mayor a 30 y si el monto_total es mayor al máximo actual
                    // if (date('i', $createdAt) > 30 && floatval($item->monto_total) < floatval($maxMonto)) {

                    if (date('i', $createdAt) > 30 && floatval($item->monto_total) > $maxMonto) {
                        // Actualizar el monto máximo y el índice del registro seleccionado
                        // $maxMonto = floatval($item->monto_total);
                        $selectedIndex = $index;
                    }

                    if (floatval($item->monto_total) > floatval($maxMonto)) {
                        $maxMonto = floatval($item->monto_total);
                    }
                }

                // Obtener el registro seleccionado usando el índice
                $selectedRecord = ($selectedIndex !== null) ? $data[$selectedIndex] : null;

                if ($selectedRecord) {
                    $wachiman->sendMessage('⚠ Posible filtración ' . $animalito->nombre . ' Loteria ' . $loteria_id);
                }

                // $socios = User::where('is_socio', 1)->get();
                // $limit = 0.1;
                // foreach ($socios as $socio) {

                //     $fund  = UserAnimalitoSchedule::where('schedule_id', $s->id)->where('animal_id', $animalito->id)->where('user_id', $socio->id)->first();

                //     if ($fund == null) {

                //         UserAnimalitoSchedule::create(['user_id' => $socio->id, 'schedule_id' => $s->id, 'animal_id' => $animalito->id, 'limit' => $limit]);
                //         info('hubo un registro');
                //     } else {
                //         $fund->limit = $limit;
                //         $fund->update();
                //         info('se actualizo un registro');
                //     }
                // }


                $telegram->sendMessage('Analisis de ' . $animalito->nombre . ' Loteria ' . $loteria_id . ' ' .  $maxMonto);
            }
        }

        $telegram->sendMessage('Se finalizo el Inspector');
    }
}
