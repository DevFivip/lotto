<?php

namespace App\Console\Commands;

use App\Http\Libs\Telegram;
use App\Http\Libs\Wachiman;
use App\Models\Animal;
use App\Models\Result;
use App\Models\Schedule;
use App\Models\SorteosType;
use App\Models\Tripleta;
use App\Models\TripletaDetail;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckTripletasWinnerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tripleta:check {loteria_id} {horario_position}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'verifica los resultados de las loterias para las tripletas';



    public function handle()
    {
        $loteria_id = $this->argument('loteria_id');
        $horario_position = $this->argument('horario_position');

        $telegram = new Telegram();
        $wachiman = new Wachiman();

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('America/Caracas'));

        $loteria = SorteosType::find($loteria_id);
        $horarios = DB::select("SELECT * FROM `results` where date(created_at) = DATE(?) and sorteo_type_id = ?", [$dt->format("Y-m-d"), intval($loteria_id)]);

        try {
            $horario = $horarios[$horario_position];
        } catch (\Throwable $th) {
            $schedules = DB::select("SELECT * FROM `schedules` where sorteo_type_id = ?", [intval($loteria_id)]);
            $lo = $loteria->name;
            $sh = $schedules[$horario_position]->schedule;
            $wachiman->sendMessage("🆘 Error al colocar resultados de la Tripleta $sh $lo");
            return 0;
        }

        // dd( $horario);

        // $row = DB::select("SELECT * FROM tripleta_details where sorteo_left > 0 and sorteo_id = ?", [$loteria_id]);
        $last_result_lotery = Result::where('sorteo_type_id', $loteria_id)->orderBy('id', 'DESC')->first();
        $animalito = Animal::find($last_result_lotery->animal_id);

        // dd($last_result_lotery, $animalito);

        // buscar donde se encuentra un registro del animalito
        // $fund = DB::select("SELECT * FROM tripleta_details where sorteo_left > 0 and sorteo_id = ? AND animal_1 = ? OR  animal_2 = ? OR  animal_3 = ?", [$horario->sorteo_type_id, $animalito->number, $animalito->number, $animalito->number]);
        $fund = DB::select("SELECT * 
                FROM tripleta_details 
                WHERE sorteo_left > 0
                  AND sorteo_id = ? 
                  AND (animal_1 = ? OR animal_2 = ? OR animal_3 = ?) 
                ORDER BY id ASC", [$horario->sorteo_type_id, $animalito->number, $animalito->number, $animalito->number]);

        foreach ($fund as $tripleta) {
            $v = 0;
            if ($tripleta->animal_1 == $animalito->number && $tripleta->animal_1_has_win == 0 && $v == 0) {
                $tr = TripletaDetail::find($tripleta->id);
                $tr->animal_1_has_win = 1;
                $v = $tripleta->id;
                $tr->update();
            }

            if ($tripleta->animal_2 == $animalito->number && $tripleta->animal_2_has_win == 0 && $v == 0) {
                $tr = TripletaDetail::find($tripleta->id);
                $tr->animal_2_has_win = 1;
                $v = $tripleta->id;
                $tr->update();
            }

            if ($tripleta->animal_3 == $animalito->number && $tripleta->animal_3_has_win == 0 && $v == 0) {
                $tr = TripletaDetail::find($tripleta->id);
                $tr->animal_3_has_win = 1;
                $v = $tripleta->id;
                $tr->update();
            }

            $TripletaVerificar3Winner = TripletaDetail::find($tripleta->id);
            if (
                $TripletaVerificar3Winner->animal_1_has_win == 1 &&
                $TripletaVerificar3Winner->animal_2_has_win == 1 &&
                $TripletaVerificar3Winner->animal_3_has_win == 1
            ) {

                $tripletaHeadActualizar = Tripleta::find($TripletaVerificar3Winner->tripleta_id);
                $tripletaHeadActualizar->has_winner = 1;
                $tripletaHeadActualizar->update();

                $TripletaVerificar3Winner->sorteo_left = 0;
                $TripletaVerificar3Winner->update();

                $telegram->sendMessage('✔ hay un Ganador con Tripleta ID ' . $TripletaVerificar3Winner->id);
            }
        }


        DB::select("UPDATE tripleta_details SET sorteo_left = sorteo_left - 1 where sorteo_left > 0 and sorteo_id = $loteria_id");

        $telegram->sendMessage('✔ Actualizacion de la Tripleta');

        return 0;
    }
}
