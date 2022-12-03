<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Illuminate\Console\Command;

class CloserHorarioLaGranjitaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:granjitaclose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cerrar sorteo de la Granjita';

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

        $s2 = Schedule::where('status', 1)->where('sorteo_type_id', '=', 2)->first(); // Cerrar Lotto Activo  
        if (!!$s2) {
            $s2->status = 0;
            $s2->update();
            // return $s->schedule . ' ' . 'off';
        } else {
            $sorteos2 = Schedule::where('sorteo_type_id', '=', 2)->get();
            foreach ($sorteos2 as $sorteo2) {
                $sorteo2->status = 1;
                $sorteo2->update();
            }
            // return 'reset off';
        }

        return 0;
    }
}
