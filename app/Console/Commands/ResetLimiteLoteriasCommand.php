<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
use App\Models\AnimalitoScheduleLimit;
use App\Models\Schedule;
use App\Models\SorteosType;
use Illuminate\Console\Command;

class ResetLimiteLoteriasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:resetlimit {loteria_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset el limite de sorteos por horas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $telegram = new Telegram();
        $loteria_id = $this->argument('loteria_id');
        $schedules = Schedule::where('sorteo_type_id', $loteria_id)->get();
        $sorteo  = SorteosType::find($loteria_id);
        $ids = $schedules->pluck('id');

        $horarios = AnimalitoScheduleLimit::whereIn('schedule_id', $ids)->get();

        foreach ($horarios as $key => $horario) {

            $horario->limit = $sorteo->limit_max;
            $horario->update();

        }

        $telegram->sendMessage('✅ Se reinicio los limites de ' . $sorteo->name . ' Monto ' . $sorteo->limit_max);


        return 0;
    }
}
