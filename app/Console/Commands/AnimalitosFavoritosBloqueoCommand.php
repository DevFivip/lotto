<?php

namespace App\Console\Commands;

use App\Models\AnimalitoScheduleLimit;
use App\Models\Config;
use App\Models\Exchange;
use App\Models\Result;
use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AnimalitosFavoritosBloqueoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:favoritos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limita los animalitos favoritos del dia';

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
        $loterias = [1, 2];
        // $date = date('Y-m-d', strtotime('-1 day'));
        $date = "2022-10-16";
        $exchange = Exchange::find(1);
        $config = 0;
        foreach ($loterias as $loteria_id) {
            switch ($loteria_id) {
                case 1:
                    $config = Config::where('name', 'PROMEDIO_LOTTO_ACTIVO')->first();
                    break;
                case 2:
                    $config = Config::where('name', 'PROMEDIO_LA_GRANJITA')->first();
                    break;
            }

            $resultados = Result::where('sorteo_type_id',$loteria_id)->orderBy('id',"DESC")->limit(11)->get();
            // dd($resultados->toArray());
            $s = Schedule::where('sorteo_type_id', $loteria_id)->where('status', 1)->orderBy('id', 'ASC')->first();

            $res = DB::select("SELECT count(*) as jugadas,
            SUM(monto) AS monto_total,
            animal_id
            FROM register_details
            WHERE DATE(register_details.created_at) >= DATE(?)
            and sorteo_type_id = ?            
            and register_details.moneda_id = 1
            group by animal_id
            order by monto_total DESC", [$date, $loteria_id]);

            $top = array_slice($res, 0, 10);

            $limit = $config->value / $exchange->change_usd;
            $limit = $limit / 1.12;
            // print_r($config->value . " " . $limit . PHP_EOL);

            foreach ($top as $t) {

                $anim = AnimalitoScheduleLimit::where('schedule_id',  $s->id)->where('animal_id', $t->animal_id)->first();
                // print_r($anim->toArray());
                $anim->limit = $limit;
                $anim->update();
            }

        }
    }
}
