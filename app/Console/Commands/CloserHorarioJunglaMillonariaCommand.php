<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
use App\Models\Schedule;
use Illuminate\Console\Command;

class CloserHorarioJunglaMillonariaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:closejunglamillonaria';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cerrar jungla millonaria';

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
        $s = Schedule::where('status', 1)->where('sorteo_type_id', 9)->first();
        if (!!$s) {
            $s->status = 0;
            $s->update();
            $telegram->sendMessage('✔ Horario Cerrado ' . $s->schedule . '  Jungla Millonaria');
            return $s->schedule . ' ' . 'off';
        } else {
            $sorteos = Schedule::where('sorteo_type_id', 9)->get();
            foreach ($sorteos as $sorteo) {
                $sorteo->status = 1;
                $sorteo->update();
            }
            $telegram->sendMessage('✔ Horarios Reiniciados Jungla Millonaria');
            return 'reset off';
        }

        return 0;
    }
}
