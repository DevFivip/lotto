<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
use App\Models\Animal;
use App\Models\AnimalitoScheduleLimit;
use App\Models\Schedule;
use App\Models\SorteosType;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReduceLimiteLoteriasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:reduce {loteria_id} {horario_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disminuir el limite de sorteos por horas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $telegram = new Telegram();

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('America/Caracas'));

        $loteria_id = $this->argument('loteria_id');
        $horario_id = $this->argument('horario_id');
        $schedule = Schedule::find($horario_id);
        $sorteo = SorteosType::find($loteria_id);
        $animals = Animal::where('sorteo_type_id', $loteria_id)->get();

        $actual = DB::select("SELECT animal_id,
        SUM(monto / exchanges.change_usd) as monto_usd
        FROM register_details
        
        LEFT JOIN exchanges ON register_details.moneda_id = exchanges.id
        
        WHERE DATE(register_details.created_at) = DATE(?)
        and register_details.schedule_id = ?
        and register_details.moneda_id = 1
        
        GROUP BY animal_id", [$dt->format("Y-m-d"), $horario_id]);

        $actual = new Collection($actual);


        $animals = $animals->map(function ($v, $k) use ($actual, $sorteo) {

            $find = $actual->search(function ($item, $key) use ($v) {
                // error_log(json_encode($v));
                // error_log(json_encode($item));
                return $item->animal_id == $v->id;
            });

            if ($find == 0 || $find !== false) {
                $v->limit_reduce = $actual[$find]->monto_usd + $sorteo->limit_reduce;
                // error_log('ENCONTRADO ' . $v->nombre);
            } else {
                $v->limit_reduce = $sorteo->limit_reduce;
            }



            return $v;
        });

        // dd($animals);

        foreach ($animals as $key => $animal) {
            $limit = AnimalitoScheduleLimit::where('schedule_id', $horario_id)->where('animal_id', $animal->id)->first();
            $limit->limit = $animal->limit_reduce;
            $limit->update();
        }





        // DB::select('UPDATE animalito_schedule_limits SET animalito_schedule_limits.`limit` = ? WHERE schedule_id = ?', [$sorteo->limit_reduce, $horario_id]);

        $telegram->sendMessage('✅ Se actualizo los limites de ' . $sorteo->name . ' horario ' . $schedule->schedule);

        return 0;
    }
}
