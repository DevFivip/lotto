<?php

namespace App\Console\Commands;

use App\Models\Exchange;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;

class GetDolarTodayExchangeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:dolarToday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener el cambio de moneda bolivares to USD';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://s3.amazonaws.com/dolartoday/data.json');
        $body = $response->json();
        $USD = $body['USD']['promedio_real'];

        $exchange = Exchange::find(1);
        $exchange->change_usd = $USD;
        $exchange->save();
        $this->info('Resultados Actualizados ' . $USD);
        return 0;
    }
}
