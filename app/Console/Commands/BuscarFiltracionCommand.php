<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Libs\Telegram;
use App\Http\Libs\Wachiman;
use App\Models\Animal;
use App\Models\AnimalitoScheduleLimit;
use App\Models\Config;
use App\Models\Schedule;
use App\Models\User;
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
        // $wachiman = new Wachiman();
        $telegram->sendMessage('Se esta ejecutando el Inspector');
        // $created_at = date('Y-m-d');
        $hora = date('Y-m-d H') . ":00:00";
        // $u = User::where('is_socio', 1)->get();

        $loterias = [1, 2];

        foreach ($loterias as $loteria_id) {
            switch ($loteria_id) {
                case 1:
                    $config = Config::where('name', 'PROMEDIO_LOTTO_ACTIVO')->first();
                    break;
                case 2:
                    $config = Config::where('name', 'PROMEDIO_LA_GRANJITA')->first();
                    break;
            }

            $limits = DB::select("SELECT count(*) as jugadas, SUM(monto) as monto FROM `register_details` WHERE created_at >= ?  and sorteo_type_id = ? ORDER BY `id` DESC", [$hora, $loteria_id]);
            $s = Schedule::where('sorteo_type_id', $loteria_id)->where('status', 1)->orderBy('id', 'asc')->first();
            $schedule = $s->schedule;
            $animals = Animal::select('id', 'nombre', 'number', 'limit_cant')->where('sorteo_type_id', $loteria_id)->get();

            foreach ($animals as $animalito) {

                $number = $animalito->id;
                $jugadas = DB::select("SELECT schedule_id as horario_id, schedule, count(*) as jugadas,
                SUM(monto) AS monto_total,
                DATE_FORMAT(from_unixtime(unix_timestamp(register_details.created_at) - unix_timestamp(register_details.created_at) mod 80), '%Y-%m-%d %H:%i:00') as createdAt 
                FROM register_details
                WHERE DATE(register_details.created_at) = DATE(?)
                and sorteo_type_id = ?
                and schedule = ?
                and register_details.animal_id = ?
                and register_details.moneda_id = 1
                group by createdAt", [$hora, $loteria_id, $schedule, $number]);


                $data = $jugadas;
                // $telegram->sendMessage(json_encode($data));
                // Inicializar el monto máximo
                $maxMonto = 0;

                // Inicializar el índice del registro seleccionado
                $selectedIndex = null;
                $posiblePago = 0;
                // Iterar sobre los registros
                foreach ($data as $index => $item) {
                    $posiblePago += floatval($item->monto_total);
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

                $telegram->sendMessage($animalito->nombre . ' Loteria ' . $loteria_id . ', Posible Pago:' . $posiblePago * 30 . ', Monto recaudado ' . $limits[0]->monto);
                // Obtener el registro seleccionado usando el índice
                $selectedRecord = ($selectedIndex !== null) ? $data[$selectedIndex] : null;

                //? cuando se detecta la irregularidad de las jugadas
                if ($selectedRecord &&  $animalito->limit_cant == 100) {
                    $telegram->sendMessage('⚠ Posible filtración ' . $animalito->nombre . ' Loteria ' . $loteria_id);

                    if (($posiblePago * 30) > $config->value && $animalito->limit_cant == 100) {
                        //?
                        $anim = AnimalitoScheduleLimit::where('schedule_id',  $s->id)->where('animal_id', $animalito->id)->first();
                        $anim->limit = 0.1;
                        $anim->update();
                        //?
                        $an = Animal::find($animalito->id);
                        $an->limit_cant = 0;
                        $an->update();

                        $telegram->sendMessage('⚠ BLOQUEADO ACTIVIDAD INUSUAL ' . $animalito->nombre . ' Loteria ' . $loteria_id);
                    }
                }

                //? cuando se detecta que el pago sobrepasa al promedio de ventas
                if ($posiblePago * 30 > $limits[0]->monto * 1.35 && $animalito->limit_cant == 100) {
                    //?
                    $anim = AnimalitoScheduleLimit::where('schedule_id',  $s->id)->where('animal_id', $animalito->id)->first();
                    $anim->limit = 2.3;
                    $anim->update();
                    //?
                    $an = Animal::find($animalito->id);
                    $an->limit_cant = 0;
                    $an->update();

                    $telegram->sendMessage('⚠ LIMITE AJUSTADO POR ACTIVIDAD IRREGULAR Y SOBREPASA EL MONTO RECAUDADO MAS EL 35% de TOLERANCIA ' . $animalito->nombre . ' Loteria ' . $loteria_id . 'Limit ' . $anim->limit);
                }

                //? cuando se detecta que el pago sobrepasa al promedio de ventas
                if ($posiblePago * 30 > $config->value * 1.15 && $animalito->limit_cant == 100) {
                    //?
                    $anim = AnimalitoScheduleLimit::where('schedule_id',  $s->id)->where('animal_id', $animalito->id)->first();
                    $anim->limit = 0.1;
                    $anim->update();
                    //?
                    $an = Animal::find($animalito->id);
                    $an->limit_cant = 0;
                    $an->update();

                    $telegram->sendMessage('⚠ BLOQUEADO SOBREPASA EL PROMEDIO DE PAGOS ' . $animalito->nombre . ' Loteria ' . $loteria_id);
                }
            }
        }

        $telegram->sendMessage('Se finalizo el Inspector');
    }
}
