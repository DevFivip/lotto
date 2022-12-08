<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
use App\Models\NextResult;
use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Client\ConnectionException;

class SendWinnerLottoPlusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loko:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar el ganador de Lotto Plus';

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
        $endpoint = env('APP_SERVIDOR_LOTTO_LOCO');
        try {
            $animalito = NextResult::with('animal')->first();
            $schedule = Schedule::where('schedule', $animalito->schedule)->where('sorteo_type_id', 4)->first();
        } catch (\Throwable $th) {
            $telegram->sendMessage('🆘 No hay animalito ganador en lotto plus, selecciona un ganador manualmente y envialo al servidor manualmente');
            $telegram->sendMessage($th);
        }



        if ($animalito) {

            $an = [
                "number" => $animalito->animal->number,
                "name" => $animalito->animal->nombre,
                "schedule" =>  $animalito->schedule
            ];

            try {
                $response = Http::withHeaders([
                    'user' => env('APP_LOTTO_USER'),
                    'password' => env('APP_LOTTO_PASSWORD')
                ])
                    ->retry(1, 2000)
                    ->post($endpoint . '/register-lotto-valid', $an);
                $re = $response->body();

                $body = json_decode($re);
                error_log($body->id);
                error_log(gettype($body));
                $telegram->sendMessage('✅ Se envio Correctamente el Resultado de Lotto Plus ' . $an['name'] . ' ' . $an['number'] . ' ' . $an['schedule']);
            } catch (ConnectionException $e) {
                //log error
                error_log($e);
                $telegram->sendMessage('❌ Error al enviar resultado de Lotto Plus');
                $telegram->sendMessage($e);
            }

            $schedule->is_send = 1;
            $schedule->update();
            //  $animalito->delete();
            return 0;
        } else {
            $telegram->sendMessage('🆘 No hay animalito ganador en lotto plus, selecciona un ganador manualmente y envialo al servidor manualmente');
            return 0;
        }

        return 0;
    }
}
