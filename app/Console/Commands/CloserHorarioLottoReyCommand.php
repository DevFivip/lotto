<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
use App\Models\Schedule;
use Illuminate\Console\Command;

class CloserHorarioLottoReyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:closelottorey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close Lotto Rey';

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
        $s = Schedule::where('status', 1)->whereNotIn('id', [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58])->where('sorteo_type_id', 6)->first();
        if (!!$s) {
            $s->status = 0;
            $s->update();
            $telegram->sendMessage('✔ Horario Cerrado ' . $s->schedule . ' Lotto Rey');
            return $s->schedule . ' ' . 'off';
        } else {
            $sorteos = Schedule::whereNotIn('id', [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58])->where('sorteo_type_id', 6)->get();
            foreach ($sorteos as $sorteo) {
                $sorteo->status = 1;
                $sorteo->update();
            }
            $telegram->sendMessage('✔ Horarios Reiniciados Lotto Rey');
            return 'reset off';
        }

        return 0;
    }
}
