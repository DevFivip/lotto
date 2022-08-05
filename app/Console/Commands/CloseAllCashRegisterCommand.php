<?php

namespace App\Console\Commands;

use App\Models\Caja;
use DateTime;
use Illuminate\Console\Command;

class CloseAllCashRegisterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cash:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra todas las cajas Abiertas';

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
        $cash = Caja::where('status', 1)->get();

        $cash->each(function ($v, $k) {
            $v->status = 0;
            $v->close_user_id =  $v->admin_id;
            $v->fecha_cierre = new DateTime('now');
            $v->update();
        });
        return true;
    }
}
