<?php

namespace App\Console\Commands;


use App\Http\Libs\Telegram;
use App\Models\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PromedioVentasSorteoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:promedios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'obtiene el promedio de ventas de cada sorteo';

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
        $loterias = [1, 2];
        $date = date('Y-m-d', strtotime('-1 day'));


        // $date = date('Y-m-d');
        // $date = "2022-10-16";
        foreach ($loterias as $loteria_id) {

            $res = DB::select("SELECT count(*) as jugadas,
            SUM(monto) AS monto_total, schedule_id
            FROM register_details
            WHERE DATE(register_details.created_at) >= DATE(?)
            and sorteo_type_id = ?
            and register_details.moneda_id = 1
            group by schedule_id
            order by monto_total DESC", [$date, $loteria_id]);
            $sum = 0;

            foreach ($res as $r) {
                $sum += $r->monto_total;
            }
            

            $promedio = $sum / 11;

            switch ($loteria_id) {
                case 1:
                    Config::createOrUpdate('PROMEDIO_LOTTO_ACTIVO', $promedio);
                    $telegram->sendMessage('PROMEDIO_LOTTO_ACTIVO ' . number_format($promedio, 2, ",", "."));
                    break;
                case 2:
                    Config::createOrUpdate('PROMEDIO_LA_GRANJITA', $promedio);
                    $telegram->sendMessage('PROMEDIO_LA_GRANJITA ' . number_format($promedio, 2, ",", "."));
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
}
