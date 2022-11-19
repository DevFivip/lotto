<?php

namespace App\Console\Commands;

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
        $s = Schedule::where('status', 1)->where('sorteo_type_id', '=', 1)->first(); // Cerrar Lotto Activo  
        if (!!$s) {
            $s->status = 0;
            $s->update();
            // return $s->schedule . ' ' . 'off';
        } else {

            $sorteos = Schedule::where('sorteo_type_id', '=', 1)->get();
            foreach ($sorteos as $sorteo) {
                $sorteo->status = 1;
                $sorteo->update();
            }
            // return 'reset off';
        }

        $s = Schedule::where('status', 1)->where('sorteo_type_id', '=', 2)->first(); // Cerrar Lotto Activo  
        if (!!$s) {
            $s->status = 0;
            $s->update();
            // return $s->schedule . ' ' . 'off';
        } else {

            $sorteos = Schedule::where('sorteo_type_id', '=', 2)->get();
            foreach ($sorteos as $sorteo) {
                $sorteo->status = 1;
                $sorteo->update();
            }
            // return 'reset off';
        }

        return 'reset off';
    }
}
