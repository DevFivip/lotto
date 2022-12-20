<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
use App\Models\AnimalitoScheduleLimit;
use App\Models\Schedule;
use App\Models\SorteosType;
use Illuminate\Console\Command;
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

        $loteria_id = $this->argument('loteria_id');
        $horario_id = $this->argument('horario_id');
        $schedule = Schedule::find($horario_id);
        $sorteo = SorteosType::find($loteria_id);

        DB::select('UPDATE animalito_schedule_limits SET animalito_schedule_limits.`limit` = ? WHERE schedule_id = ?', [$sorteo->limit_reduce, $horario_id]);

        $telegram->sendMessage('✅ Se actualizo los limites de ' . $sorteo->name . ' horario ' . $schedule->schedule);

        return 0;
    }
}
