<?php

namespace App\Console\Commands;

use App\Jobs\BuscarFiltracion;
use Illuminate\Console\Command;

class BuscarFiltracionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:filtracion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca si hay una variacion en la venta para encontrar una filtracion';

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
        BuscarFiltracion::dispatchAfterResponse();
    }
}
