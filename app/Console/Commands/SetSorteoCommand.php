<?php

namespace App\Console\Commands;

use App\Config;
use App\Http\Libs\Telegram;
use App\Models\Schedule;
use Illuminate\Console\Command;

class SetSorteoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:set';

    /**
     * The console sorteo description.
     *
     * @var string
     */
    protected $description = 'Cambia el status de cada sorteo';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $telegram = new Telegram();
        $s2 = Schedule::where('status', 1)->whereNotIn('id',Config::BANEDSCHEDULES)->where('sorteo_type_id', '=', 1)->first(); // Cerrar Lotto Activo  
        if (!!$s2) {
            $s2->status = 0;
            $s2->update();
            $telegram->sendMessage('✔ Horario Cerrado ' . $s2->schedule . ' Lotto Activo');
            return $s2->schedule . ' ' . 'off';
        } else {
            $sorteos2 = Schedule::whereNotIn('id',Config::BANEDSCHEDULES)->where('sorteo_type_id', '=', 1)->get();
            foreach ($sorteos2 as $sorteo2) {
                $sorteo2->status = 1;
                $sorteo2->update();
            }
            $telegram->sendMessage('✔ Horarios Reiniciados Lotto Activo');
            return 'reset off';
        }

        return 0;
    }
}
