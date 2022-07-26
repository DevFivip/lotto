<?php

namespace App\Console\Commands;

use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScrappingController;
use App\Models\Schedule;
use Illuminate\Console\Command;

class GetSorteoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'actualiza el ultimo resultado de lottoactivo.com y actualiza el listado de ganadores';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $scrapping = new ScrappingController();
        $resultados = $scrapping->scrap();

        //obtener el ultimo resultado
        // dd($resultados);
        $ultimoResultado = $resultados[count($resultados) - 1];
        //validar que el sorteo que se va a ingresar este desactivado
        $schedule = Schedule::where('id', $ultimoResultado['horario'])->where('status', 0)->first();
        if ($schedule) {
            $response = ResultController::storeDirect($ultimoResultado['numero'], $ultimoResultado['horario']);

            $this->info('Resultados Actualizados');
            return ['exito'];
        } else {
            $this->error('Something went wrong!');
            return ['sorteo realizado'];
        }

        return $resultados;
    }
}
