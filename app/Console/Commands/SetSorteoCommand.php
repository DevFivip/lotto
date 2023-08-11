<?php

namespace App\Console\Commands;

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
        $s = Schedule::where('status', 1)->where('sorteo_type_id', '=', 1)->first(); // Cerrar Lotto Activo  
        if (!!$s) {
            $s->status = 0;
            $s->update();
            $telegram->sendMessage('✔ Horario Cerrado ' . $s->schedule . '  Lotto Activo');
            return $s->schedule . ' ' . 'off';
        } else {

            $sorteos = Schedule::where('sorteo_type_id', '=', 1)->get();
            foreach ($sorteos as $sorteo) {
                $sorteo->status = 1;
                $sorteo->update();
            }
            $telegram->sendMessage('✔ Horarios Reiniciados Lotto Activo');
            return 'reset off';
        }



        return 'reset off';
    }
}
