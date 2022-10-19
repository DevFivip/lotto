<?php

namespace App\Console\Commands;

use App\Models\NextResult;
use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        $endpoint = env('APP_SERVIDOR_LOTTO_LOCO');
        $animalito = NextResult::with('animal')->first();

        $schedule = Schedule::where('schedule', $animalito->schedule)->where('sorteo_type_id', 4)->first();

        if ($animalito) {
            $an = [
                "number" => $animalito->animal->number,
                "name" => $animalito->animal->nombre,
                "schedule" =>  $animalito->schedule
            ];

            $response = Http::withHeaders([
                'user' => env('APP_LOTTO_USER'),
                'password' => env('APP_LOTTO_PASSWORD')
            ])
                ->post($endpoint . '/register-lotto-valid', $an);


            $schedule->is_send = 1;
            $schedule->update();
            $animalito->delete();
            return 0;
        } else {
            return 0;
        }

        return 0;
    }
}
