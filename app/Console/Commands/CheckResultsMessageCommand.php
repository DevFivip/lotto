<?php

namespace App\Console\Commands;

use App\Http\Libs\Wachiman;
use App\Models\Register;
use App\Models\Schedule;
use App\Models\SorteosType;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckResultsMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:checkresult {loteria_id} {horario_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que el resultado se encuentre registrado';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $loteria_id = $this->argument('loteria_id');
        $horario_id = $this->argument('horario_id');

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('America/Caracas'));

        $res = DB::select("SELECT * FROM `results` where date(created_at) = DATE(?) and schedule_id = ? and sorteo_type_id = ?", [$dt->format("Y-m-d"), $horario_id, $loteria_id]);

        // error_log(json_encode($res));

        if (count($res) == 0) {
            $loteria = SorteosType::find($loteria_id);
            $horario = Schedule::find($horario_id);
            #mandar mensaje
            $w = new Wachiman();
            $w->sendMessage("🆘 Pendiente Resultado " . $loteria->name . " " . $horario->schedule);
        }

        return 0;
    }
}
