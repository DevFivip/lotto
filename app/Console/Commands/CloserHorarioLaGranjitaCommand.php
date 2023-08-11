<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
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
        $telegram = new Telegram();
        $s2 = Schedule::where('status', 1)->whereNotIn('id', [25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35])->where('sorteo_type_id', '=', 2)->first(); // Cerrar Lotto Activo  
        if (!!$s2) {
            $s2->status = 0;
            $s2->update();
            $telegram->sendMessage('✔ Horario Cerrado ' . $s2->schedule . '  La Granjita');
            return $s2->schedule . ' ' . 'off';
        } else {
            $sorteos2 = Schedule::where('sorteo_type_id', '=', 2)->get();
            foreach ($sorteos2 as $sorteo2) {
                $sorteo2->status = 1;
                $sorteo2->update();
            }
            $telegram->sendMessage('✔ Horarios Reiniciados La Granjita');
            return 'reset off';
        }

        return 0;
    }
}
