<?php

namespace App\Console\Commands;

use App\Http\Controllers\ResultController;
use App\Models\Animal;
use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetResultLottoPlus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loko:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'obtener resultados de lotto plus';

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

        $url = env('APP_SERVIDOR_LOTTO_LOCO') . '/last-result';
        $response = Http::post($url);
        $body = $response->json();

        // dd($body);
        // $animal = Animal::where('number', $body['number'])->where('sorteo_type_id', 4)->first();
        $schedule = Schedule::where('schedule', $body['schedule'])->where('sorteo_type_id', 4)->first();
        $res = ResultController::storeDirectLottoPlus($body['number'],$schedule->id);
        // dd($res);
        $this->info('Resultados Actualizados');
        return 0;
    }
}
