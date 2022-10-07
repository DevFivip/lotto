<?php

namespace App\Console\Commands;

use App\Models\Caja;
use App\Models\CajaRegister;
use App\Models\CajaRegisterDetail;
use App\Models\CashFlow;
use App\Models\Exchange;
use App\Models\RegisterDetail;
use App\Models\User;
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



            // return false;
            $ventas = RegisterDetail::where('user_id', $v->user_id)->where('caja_id', $v->id)->get();
            $user = User::find($v->user_id);
            $caja_id = $v->id;
            $arr_monedas = $ventas->groupBy('moneda_id');

            $caja = CajaRegister::create([
                "admin_id" => $user->parent_id,
                "user_id" => $user->id,
                "caja_id" => $caja_id,
                "total_tickets_cant" => $ventas->count()
            ]);
            $_caja_id = $caja->id;


            $arr_monedas->each(function ($vv, $moneda_id) use ($user, $caja_id, $_caja_id) {
                $moneda = Exchange::find($moneda_id);
                $gruped_tickets = $vv->sum('monto');
                $ganadores = $vv->sum(function ($l) {
                    if ($l->winner == 1) {
                        $porcent = 0;
                        switch ($l->sorteo_type_id) {
                            case 1:
                                $porcent = 30;
                                break;
                            case 4:
                                $porcent = 30;
                                break;
                            default:
                                $porcent = 30;
                                break;
                        }
                        return $l->monto * $porcent;
                    } else {
                        return 0;
                    }
                });
                $comision = $gruped_tickets / (100 / $user->comision);
                $balance = $gruped_tickets - $ganadores - $comision;
                $total_usdt = $gruped_tickets / $moneda->change_usd;
                CajaRegisterDetail::create([
                    "type" => "1",
                    "detalle" => "Venta del Día",
                    "caja_registers_id" => $_caja_id,
                    "admin_id" => $user->parent_id,
                    "user_id" => $user->id,
                    "moneda_id" => $moneda_id,
                    "total" => $gruped_tickets,
                    "comision" => $comision,
                    "premio" => $ganadores,
                    "balance" => $balance,
                    "exchange" => $moneda->change_usd,
                    "total_usdt" => $total_usdt,
                ]);
                // dd($gruped_tickets, $comision, $ganadores, $user->comision, $balance ,$moneda_id,$total_usdt);
            });



            $flow = CashFlow::where('caja_id', $caja_id)->get();
            $arr_flow_monedas = $flow->groupBy('moneda_id');

            $arr_flow_monedas->each(function ($vv, $moneda_id) use ($user, $caja_id, $_caja_id) {
                $moneda = Exchange::find($moneda_id);
                $vv->each(function ($item, $key) use ($user, $_caja_id, $moneda, $moneda_id) {
                    $total_usdt = $item->total / $moneda->change_usd;
                    CajaRegisterDetail::create([
                        "type" => $item->type,
                        "detalle" => $item->detalle,
                        "caja_registers_id" => $_caja_id,
                        "admin_id" => $user->parent_id,
                        "user_id" => $user->id,
                        "moneda_id" => $moneda_id,
                        "total" => $item->total,
                        "comision" => 0,
                        "premio" => 0,
                        "balance" => $item->total,
                        "exchange" => $moneda->change_usd,
                        "total_usdt" => $total_usdt,
                    ]);
                });
            });


            // cerrar la caja
            $v->status = 0;
            $v->close_user_id =  $v->admin_id;
            $v->fecha_cierre = new DateTime('now');
            $v->update();

        });
        return true;
    }
}
