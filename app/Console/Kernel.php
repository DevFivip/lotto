<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        Commands\CloserHorarioChanceAnimalitosCommand::class,
        Commands\CloserHorarioGuacharoActivoCommand::class,
        Commands\CloserHorarioJunglaMillonariaCommand::class,
        Commands\CloserHorarioLaGranjitaCommand::class,
        Commands\CloserHorarioLottoReyCommand::class,
        Commands\CloserHorarioSelvaParaisoCommand::class,
        Commands\CloserHorarioSelvaPlusCommand::class,
        Commands\CloserHorarioTropiGanaCommand::class,
        Commands\ReduceLimiteLoteriasCommand::class,
        Commands\ResetLimiteLoteriasCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        //  $schedule->command('exchange:dolarToday')->everyFourMinutes();
        //LA GRANJITA

        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('08:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('09:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('10:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('11:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('12:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('13:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('14:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('15:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('16:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('17:59');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('18:59');

        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('03:50'); // reset granjita open all

        // Selva Paraiso PERU
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('08:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('09:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('10:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('11:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('12:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('13:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('14:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('15:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('16:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('17:51');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('18:51');

        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('03:47'); // reset selva paraiso


        // LOTTO ACTIVO RD
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('08:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('09:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('10:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('11:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('12:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('13:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('14:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('15:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('16:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('17:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('18:29');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('19:29');

        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('03:55'); // reset lotto activo rd open all


        // $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('08:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('09:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('10:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('11:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('12:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('13:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('14:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('15:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('16:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('17:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('18:20');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('19:20');

        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('03:49'); // reset lotto activo rd open all


        // Chance con Animalitos
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('08:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('09:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('10:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('11:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('12:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('13:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('14:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('15:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('16:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('17:52');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('18:52');

        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('03:56'); // reset granjita open all


        // Tropi Gana        
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('08:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('09:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('10:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('11:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('12:53');
        // $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('13:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('14:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('15:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('16:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('17:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('18:53');

        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('03:57'); // reset granjita open all


        // JUNGLA MILLONARIA
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('08:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('09:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('10:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('11:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('12:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('13:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('14:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('15:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('16:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('17:54');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('18:54');

        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('03:58'); // reset granjita open all


        // Guacharo Activo
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('08:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('09:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('10:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('11:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('12:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('13:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('14:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('15:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('16:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('17:55');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('18:55');

        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('04:00'); // reset granjita open all


        // Selva Plus
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('08:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('09:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('10:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('11:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('12:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('13:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('14:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('15:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('16:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('17:55');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('18:55');

        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('04:01'); // reset granjita open all



        // Lotto Activo Reducir limites
        $schedule->command('sorteo:reduce 1 1')->timezone('America/Caracas')->at('08:40');
        $schedule->command('sorteo:reduce 1 2')->timezone('America/Caracas')->at('09:40');
        $schedule->command('sorteo:reduce 1 3')->timezone('America/Caracas')->at('10:40');
        $schedule->command('sorteo:reduce 1 4')->timezone('America/Caracas')->at('11:40');
        $schedule->command('sorteo:reduce 1 5')->timezone('America/Caracas')->at('12:40');
        $schedule->command('sorteo:reduce 1 6')->timezone('America/Caracas')->at('13:40');
        $schedule->command('sorteo:reduce 1 7')->timezone('America/Caracas')->at('14:40');
        $schedule->command('sorteo:reduce 1 8')->timezone('America/Caracas')->at('15:40');
        $schedule->command('sorteo:reduce 1 9')->timezone('America/Caracas')->at('16:40');
        $schedule->command('sorteo:reduce 1 10')->timezone('America/Caracas')->at('17:40');
        $schedule->command('sorteo:reduce 1 11')->timezone('America/Caracas')->at('18:40');


        $schedule->command('sorteo:reduce 2 25')->timezone('America/Caracas')->at('08:40');
        $schedule->command('sorteo:reduce 2 26')->timezone('America/Caracas')->at('09:40');
        $schedule->command('sorteo:reduce 2 27')->timezone('America/Caracas')->at('10:40');
        $schedule->command('sorteo:reduce 2 28')->timezone('America/Caracas')->at('11:40');
        $schedule->command('sorteo:reduce 2 29')->timezone('America/Caracas')->at('12:40');
        $schedule->command('sorteo:reduce 2 30')->timezone('America/Caracas')->at('13:40');
        $schedule->command('sorteo:reduce 2 31')->timezone('America/Caracas')->at('14:40');
        $schedule->command('sorteo:reduce 2 32')->timezone('America/Caracas')->at('15:40');
        $schedule->command('sorteo:reduce 2 33')->timezone('America/Caracas')->at('16:40');
        $schedule->command('sorteo:reduce 2 34')->timezone('America/Caracas')->at('17:40');
        $schedule->command('sorteo:reduce 2 35')->timezone('America/Caracas')->at('18:40');


        $schedule->command('sorteo:reduce 5 36')->timezone('America/Caracas')->at('08:10');
        $schedule->command('sorteo:reduce 5 37')->timezone('America/Caracas')->at('09:10');
        $schedule->command('sorteo:reduce 5 38')->timezone('America/Caracas')->at('10:10');
        $schedule->command('sorteo:reduce 5 39')->timezone('America/Caracas')->at('11:10');
        $schedule->command('sorteo:reduce 5 40')->timezone('America/Caracas')->at('12:10');
        $schedule->command('sorteo:reduce 5 41')->timezone('America/Caracas')->at('13:10');
        $schedule->command('sorteo:reduce 5 42')->timezone('America/Caracas')->at('14:10');
        $schedule->command('sorteo:reduce 5 43')->timezone('America/Caracas')->at('15:10');
        $schedule->command('sorteo:reduce 5 44')->timezone('America/Caracas')->at('16:10');
        $schedule->command('sorteo:reduce 5 45')->timezone('America/Caracas')->at('17:10');
        $schedule->command('sorteo:reduce 5 46')->timezone('America/Caracas')->at('18:10');
        $schedule->command('sorteo:reduce 5 47')->timezone('America/Caracas')->at('19:10');

        $schedule->command('sorteo:reduce 6 48')->timezone('America/Caracas')->at('09:10');
        $schedule->command('sorteo:reduce 6 49')->timezone('America/Caracas')->at('10:10');
        $schedule->command('sorteo:reduce 6 50')->timezone('America/Caracas')->at('11:10');
        $schedule->command('sorteo:reduce 6 51')->timezone('America/Caracas')->at('12:10');
        $schedule->command('sorteo:reduce 6 52')->timezone('America/Caracas')->at('13:10');
        $schedule->command('sorteo:reduce 6 53')->timezone('America/Caracas')->at('14:10');
        $schedule->command('sorteo:reduce 6 54')->timezone('America/Caracas')->at('15:10');
        $schedule->command('sorteo:reduce 6 55')->timezone('America/Caracas')->at('16:10');
        $schedule->command('sorteo:reduce 6 56')->timezone('America/Caracas')->at('17:10');
        $schedule->command('sorteo:reduce 6 57')->timezone('America/Caracas')->at('18:10');
        $schedule->command('sorteo:reduce 6 58')->timezone('America/Caracas')->at('19:10');


        $schedule->command('sorteo:reduce 3 113')->timezone('America/Lima')->at('08:40');
        $schedule->command('sorteo:reduce 3 114')->timezone('America/Lima')->at('09:40');
        $schedule->command('sorteo:reduce 3 115')->timezone('America/Lima')->at('10:40');
        $schedule->command('sorteo:reduce 3 116')->timezone('America/Lima')->at('11:40');
        $schedule->command('sorteo:reduce 3 117')->timezone('America/Lima')->at('12:40');
        $schedule->command('sorteo:reduce 3 118')->timezone('America/Lima')->at('13:40');
        $schedule->command('sorteo:reduce 3 119')->timezone('America/Lima')->at('14:40');
        $schedule->command('sorteo:reduce 3 120')->timezone('America/Lima')->at('15:40');
        $schedule->command('sorteo:reduce 3 121')->timezone('America/Lima')->at('16:40');
        $schedule->command('sorteo:reduce 3 122')->timezone('America/Lima')->at('17:40');
        $schedule->command('sorteo:reduce 3 123')->timezone('America/Lima')->at('18:40');


        $schedule->command('sorteo:resetlimit 1')->timezone('America/Caracas')->at('03:40');
        $schedule->command('sorteo:resetlimit 2')->timezone('America/Caracas')->at('03:41');
        $schedule->command('sorteo:resetlimit 3')->timezone('America/Caracas')->at('03:42');
        $schedule->command('sorteo:resetlimit 5')->timezone('America/Caracas')->at('03:43');
        $schedule->command('sorteo:resetlimit 6')->timezone('America/Caracas')->at('03:44');



        // $schedule->command('sorteo:set')->timezone('America/New_York')->at('2:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
