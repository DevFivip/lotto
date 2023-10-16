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
        Commands\CheckResultsMessageCommand::class,
        Commands\BuscarFiltracionCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        //  $schedule->command('exchange:dolarToday')->everyFourMinutes();


        // LOTTO ACTIVO

        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('08:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('09:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('10:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('11:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('12:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('13:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('14:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('15:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('16:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('17:59');
        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('18:59');

        $schedule->command('sorteo:set')->timezone('America/Caracas')->at('03:50'); // reset lotto activo open all


        //LA GRANJITA
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('07:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('08:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('09:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('10:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('11:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('12:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('13:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('14:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('15:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('16:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('17:55');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('18:55');

        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('23:50'); // reset granjita open all

        // RULETA ACTIVO
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('08:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('09:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('10:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('11:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('12:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('13:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('14:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('15:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('16:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('17:55');
        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('18:55');

        $schedule->command('sorteo:lottoactivoregalos')->timezone('America/Caracas')->at('23:51'); // reset granjita open all

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
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('09:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('10:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('11:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('12:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('13:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('14:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('15:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('16:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('17:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('18:29');
        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('19:29');

        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('03:49'); // reset lotto activo rd open all


        // Chance con Animalitos
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('08:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('09:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('10:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('11:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('12:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('13:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('14:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('15:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('16:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('17:55');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('18:55');

        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('03:56'); // reset granjita open all


        // Tropi Gana        
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('08:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('09:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('10:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('11:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('12:53');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('13:53');
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
        // $schedule->command('sorteo:reduce 1 1')->timezone('America/Caracas')->at('08:30');
        // $schedule->command('sorteo:reduce 1 2')->timezone('America/Caracas')->at('09:30');
        // $schedule->command('sorteo:reduce 1 3')->timezone('America/Caracas')->at('10:30');
        // $schedule->command('sorteo:reduce 1 4')->timezone('America/Caracas')->at('11:30');
        // $schedule->command('sorteo:reduce 1 5')->timezone('America/Caracas')->at('12:30');
        // $schedule->command('sorteo:reduce 1 6')->timezone('America/Caracas')->at('13:30');
        // $schedule->command('sorteo:reduce 1 7')->timezone('America/Caracas')->at('14:30');
        // $schedule->command('sorteo:reduce 1 8')->timezone('America/Caracas')->at('15:30');
        // $schedule->command('sorteo:reduce 1 9')->timezone('America/Caracas')->at('16:30');
        // $schedule->command('sorteo:reduce 1 10')->timezone('America/Caracas')->at('17:30');
        // $schedule->command('sorteo:reduce 1 11')->timezone('America/Caracas')->at('18:30');


        // $schedule->command('sorteo:reduce 2 135')->timezone('America/Caracas')->at('07:30');
        // $schedule->command('sorteo:reduce 2 136')->timezone('America/Caracas')->at('08:30');
        // $schedule->command('sorteo:reduce 2 137')->timezone('America/Caracas')->at('09:30');
        // $schedule->command('sorteo:reduce 2 138')->timezone('America/Caracas')->at('10:30');
        // $schedule->command('sorteo:reduce 2 139')->timezone('America/Caracas')->at('11:30');
        // $schedule->command('sorteo:reduce 2 140')->timezone('America/Caracas')->at('12:30');
        // $schedule->command('sorteo:reduce 2 141')->timezone('America/Caracas')->at('13:30');
        // $schedule->command('sorteo:reduce 2 142')->timezone('America/Caracas')->at('14:30');
        // $schedule->command('sorteo:reduce 2 143')->timezone('America/Caracas')->at('15:30');
        // $schedule->command('sorteo:reduce 2 144')->timezone('America/Caracas')->at('16:30');
        // $schedule->command('sorteo:reduce 2 145')->timezone('America/Caracas')->at('17:30');
        // $schedule->command('sorteo:reduce 2 146')->timezone('America/Caracas')->at('18:30');


        // $schedule->command('sorteo:reduce 5 36')->timezone('America/Caracas')->at('08:10');
        // $schedule->command('sorteo:reduce 5 37')->timezone('America/Caracas')->at('09:10');
        // $schedule->command('sorteo:reduce 5 38')->timezone('America/Caracas')->at('10:10');
        // $schedule->command('sorteo:reduce 5 39')->timezone('America/Caracas')->at('11:10');
        // $schedule->command('sorteo:reduce 5 40')->timezone('America/Caracas')->at('12:10');
        // $schedule->command('sorteo:reduce 5 41')->timezone('America/Caracas')->at('13:10');
        // $schedule->command('sorteo:reduce 5 42')->timezone('America/Caracas')->at('14:10');
        // $schedule->command('sorteo:reduce 5 43')->timezone('America/Caracas')->at('15:10');
        // $schedule->command('sorteo:reduce 5 44')->timezone('America/Caracas')->at('16:10');
        // $schedule->command('sorteo:reduce 5 45')->timezone('America/Caracas')->at('17:10');
        // $schedule->command('sorteo:reduce 5 46')->timezone('America/Caracas')->at('18:10');
        // $schedule->command('sorteo:reduce 5 47')->timezone('America/Caracas')->at('19:10');

        // $schedule->command('sorteo:reduce 6 48')->timezone('America/Caracas')->at('09:10');
        // $schedule->command('sorteo:reduce 6 49')->timezone('America/Caracas')->at('10:10');
        // $schedule->command('sorteo:reduce 6 50')->timezone('America/Caracas')->at('11:10');
        // $schedule->command('sorteo:reduce 6 51')->timezone('America/Caracas')->at('12:10');
        // $schedule->command('sorteo:reduce 6 52')->timezone('America/Caracas')->at('13:10');
        // $schedule->command('sorteo:reduce 6 53')->timezone('America/Caracas')->at('14:10');
        // $schedule->command('sorteo:reduce 6 54')->timezone('America/Caracas')->at('15:10');
        // $schedule->command('sorteo:reduce 6 55')->timezone('America/Caracas')->at('16:10');
        // $schedule->command('sorteo:reduce 6 56')->timezone('America/Caracas')->at('17:10');
        // $schedule->command('sorteo:reduce 6 57')->timezone('America/Caracas')->at('18:10');
        // $schedule->command('sorteo:reduce 6 58')->timezone('America/Caracas')->at('19:10');

        // // chance con animalitos
        // $schedule->command('sorteo:reduce 7 59')->timezone('America/Caracas')->at('09:30');
        // $schedule->command('sorteo:reduce 7 60')->timezone('America/Caracas')->at('10:30');
        // $schedule->command('sorteo:reduce 7 61')->timezone('America/Caracas')->at('11:30');
        // $schedule->command('sorteo:reduce 7 62')->timezone('America/Caracas')->at('12:30');
        // $schedule->command('sorteo:reduce 7 63')->timezone('America/Caracas')->at('13:30');
        // $schedule->command('sorteo:reduce 7 64')->timezone('America/Caracas')->at('14:30');
        // $schedule->command('sorteo:reduce 7 65')->timezone('America/Caracas')->at('15:30');
        // $schedule->command('sorteo:reduce 7 66')->timezone('America/Caracas')->at('16:30');
        // $schedule->command('sorteo:reduce 7 67')->timezone('America/Caracas')->at('17:30');
        // $schedule->command('sorteo:reduce 7 68')->timezone('America/Caracas')->at('18:30');
        // $schedule->command('sorteo:reduce 7 69')->timezone('America/Caracas')->at('19:30');


        // $schedule->command('sorteo:reduce 3 113')->timezone('America/Lima')->at('08:30');
        // $schedule->command('sorteo:reduce 3 114')->timezone('America/Lima')->at('09:30');
        // $schedule->command('sorteo:reduce 3 115')->timezone('America/Lima')->at('10:30');
        // $schedule->command('sorteo:reduce 3 116')->timezone('America/Lima')->at('11:30');
        // $schedule->command('sorteo:reduce 3 117')->timezone('America/Lima')->at('12:30');
        // $schedule->command('sorteo:reduce 3 118')->timezone('America/Lima')->at('13:30');
        // $schedule->command('sorteo:reduce 3 119')->timezone('America/Lima')->at('14:30');
        // $schedule->command('sorteo:reduce 3 120')->timezone('America/Lima')->at('15:30');
        // $schedule->command('sorteo:reduce 3 121')->timezone('America/Lima')->at('16:30');
        // $schedule->command('sorteo:reduce 3 122')->timezone('America/Lima')->at('17:30');
        // $schedule->command('sorteo:reduce 3 123')->timezone('America/Lima')->at('18:30');


        // $schedule->command('sorteo:reduce 10 91')->timezone('America/Lima')->at('08:30');
        // $schedule->command('sorteo:reduce 10 92')->timezone('America/Lima')->at('09:30');
        // $schedule->command('sorteo:reduce 10 93')->timezone('America/Lima')->at('10:30');
        // $schedule->command('sorteo:reduce 10 94')->timezone('America/Lima')->at('11:30');
        // $schedule->command('sorteo:reduce 10 95')->timezone('America/Lima')->at('12:30');
        // $schedule->command('sorteo:reduce 10 96')->timezone('America/Lima')->at('13:30');
        // $schedule->command('sorteo:reduce 10 97')->timezone('America/Lima')->at('14:30');
        // $schedule->command('sorteo:reduce 10 98')->timezone('America/Lima')->at('15:30');
        // $schedule->command('sorteo:reduce 10 99')->timezone('America/Lima')->at('16:30');
        // $schedule->command('sorteo:reduce 10 100')->timezone('America/Lima')->at('17:30');
        // $schedule->command('sorteo:reduce 10 101')->timezone('America/Lima')->at('18:30');

        // $schedule->command('sorteo:reduce 11 102')->timezone('America/Lima')->at('08:30');
        // $schedule->command('sorteo:reduce 11 103')->timezone('America/Lima')->at('09:30');
        // $schedule->command('sorteo:reduce 11 104')->timezone('America/Lima')->at('10:30');
        // $schedule->command('sorteo:reduce 11 105')->timezone('America/Lima')->at('11:30');
        // $schedule->command('sorteo:reduce 11 106')->timezone('America/Lima')->at('12:30');
        // $schedule->command('sorteo:reduce 11 107')->timezone('America/Lima')->at('13:30');
        // $schedule->command('sorteo:reduce 11 108')->timezone('America/Lima')->at('14:30');
        // $schedule->command('sorteo:reduce 11 109')->timezone('America/Lima')->at('15:30');
        // $schedule->command('sorteo:reduce 11 110')->timezone('America/Lima')->at('16:30');
        // $schedule->command('sorteo:reduce 11 111')->timezone('America/Lima')->at('17:30');
        // $schedule->command('sorteo:reduce 11 112')->timezone('America/Lima')->at('18:30');

        // // Reduce Ruleta Activa
        // $schedule->command('sorteo:reduce 12 124')->timezone('America/Lima')->at('08:30');
        // $schedule->command('sorteo:reduce 12 125')->timezone('America/Lima')->at('09:30');
        // $schedule->command('sorteo:reduce 12 126')->timezone('America/Lima')->at('10:30');
        // $schedule->command('sorteo:reduce 12 127')->timezone('America/Lima')->at('11:30');
        // $schedule->command('sorteo:reduce 12 128')->timezone('America/Lima')->at('12:30');
        // $schedule->command('sorteo:reduce 12 129')->timezone('America/Lima')->at('13:30');
        // $schedule->command('sorteo:reduce 12 130')->timezone('America/Lima')->at('14:30');
        // $schedule->command('sorteo:reduce 12 131')->timezone('America/Lima')->at('15:30');
        // $schedule->command('sorteo:reduce 12 132')->timezone('America/Lima')->at('16:30');
        // $schedule->command('sorteo:reduce 12 133')->timezone('America/Lima')->at('17:30');
        // $schedule->command('sorteo:reduce 12 134')->timezone('America/Lima')->at('18:30');


        $schedule->command('sorteo:resetlimit 1')->timezone('America/Caracas')->at('03:40');
        $schedule->command('sorteo:resetlimit 2')->timezone('America/Caracas')->at('03:41');
        $schedule->command('sorteo:resetlimit 3')->timezone('America/Caracas')->at('03:42');
        $schedule->command('sorteo:resetlimit 5')->timezone('America/Caracas')->at('03:43');
        $schedule->command('sorteo:resetlimit 6')->timezone('America/Caracas')->at('03:44');
        $schedule->command('sorteo:resetlimit 7')->timezone('America/Caracas')->at('03:44');
        $schedule->command('sorteo:resetlimit 10')->timezone('America/Caracas')->at('03:45');
        $schedule->command('sorteo:resetlimit 11')->timezone('America/Caracas')->at('03:45');
        $schedule->command('sorteo:resetlimit 12')->timezone('America/Caracas')->at('03:45');


        //////////////////////////// TRIPLETAS //////////////////////////////////////////////

        // TRIPLETAS LOTTO ACTIVO

        $schedule->command('sorteo:checkresult 1 1')->timezone('America/Caracas')->at('09:15');
        $schedule->command('sorteo:checkresult 1 2')->timezone('America/Caracas')->at('10:15');
        $schedule->command('sorteo:checkresult 1 3')->timezone('America/Caracas')->at('11:15');
        $schedule->command('sorteo:checkresult 1 4')->timezone('America/Caracas')->at('12:15');
        $schedule->command('sorteo:checkresult 1 5')->timezone('America/Caracas')->at('13:15');
        $schedule->command('sorteo:checkresult 1 6')->timezone('America/Caracas')->at('14:15');
        $schedule->command('sorteo:checkresult 1 7')->timezone('America/Caracas')->at('15:15');
        $schedule->command('sorteo:checkresult 1 8')->timezone('America/Caracas')->at('16:15');
        $schedule->command('sorteo:checkresult 1 9')->timezone('America/Caracas')->at('17:15');
        $schedule->command('sorteo:checkresult 1 10')->timezone('America/Caracas')->at('18:15');
        $schedule->command('sorteo:checkresult 1 11')->timezone('America/Caracas')->at('19:15');

        $schedule->command('sorteo:checkresult 4 12')->timezone('America/Caracas')->at('08:06');
        $schedule->command('sorteo:checkresult 4 13')->timezone('America/Caracas')->at('09:06');
        $schedule->command('sorteo:checkresult 4 14')->timezone('America/Caracas')->at('10:06');
        $schedule->command('sorteo:checkresult 4 15')->timezone('America/Caracas')->at('11:06');
        $schedule->command('sorteo:checkresult 4 16')->timezone('America/Caracas')->at('12:06');
        $schedule->command('sorteo:checkresult 4 17')->timezone('America/Caracas')->at('13:06');
        $schedule->command('sorteo:checkresult 4 18')->timezone('America/Caracas')->at('14:06');
        $schedule->command('sorteo:checkresult 4 19')->timezone('America/Caracas')->at('15:06');
        $schedule->command('sorteo:checkresult 4 20')->timezone('America/Caracas')->at('16:06');
        $schedule->command('sorteo:checkresult 4 21')->timezone('America/Caracas')->at('17:06');
        $schedule->command('sorteo:checkresult 4 22')->timezone('America/Caracas')->at('18:06');
        $schedule->command('sorteo:checkresult 4 23')->timezone('America/Caracas')->at('19:06');
        $schedule->command('sorteo:checkresult 4 24')->timezone('America/Caracas')->at('20:06');

        $schedule->command('sorteo:checkresult 2 135')->timezone('America/Caracas')->at('08:15');
        $schedule->command('sorteo:checkresult 2 136')->timezone('America/Caracas')->at('09:15');
        $schedule->command('sorteo:checkresult 2 137')->timezone('America/Caracas')->at('10:15');
        $schedule->command('sorteo:checkresult 2 138')->timezone('America/Caracas')->at('11:15');
        $schedule->command('sorteo:checkresult 2 139')->timezone('America/Caracas')->at('12:15');
        $schedule->command('sorteo:checkresult 2 140')->timezone('America/Caracas')->at('13:15');
        $schedule->command('sorteo:checkresult 2 141')->timezone('America/Caracas')->at('14:15');
        $schedule->command('sorteo:checkresult 2 142')->timezone('America/Caracas')->at('15:15');
        $schedule->command('sorteo:checkresult 2 143')->timezone('America/Caracas')->at('16:15');
        $schedule->command('sorteo:checkresult 2 144')->timezone('America/Caracas')->at('17:15');
        $schedule->command('sorteo:checkresult 2 145')->timezone('America/Caracas')->at('18:15');
        $schedule->command('sorteo:checkresult 2 146')->timezone('America/Caracas')->at('19:15');

        $schedule->command('sorteo:checkresult 5 36')->timezone('America/Caracas')->at('08:45');
        $schedule->command('sorteo:checkresult 5 37')->timezone('America/Caracas')->at('09:45');
        $schedule->command('sorteo:checkresult 5 38')->timezone('America/Caracas')->at('10:45');
        $schedule->command('sorteo:checkresult 5 39')->timezone('America/Caracas')->at('11:45');
        $schedule->command('sorteo:checkresult 5 40')->timezone('America/Caracas')->at('12:45');
        $schedule->command('sorteo:checkresult 5 41')->timezone('America/Caracas')->at('13:45');
        $schedule->command('sorteo:checkresult 5 42')->timezone('America/Caracas')->at('14:45');
        $schedule->command('sorteo:checkresult 5 43')->timezone('America/Caracas')->at('15:45');
        $schedule->command('sorteo:checkresult 5 44')->timezone('America/Caracas')->at('16:45');
        $schedule->command('sorteo:checkresult 5 45')->timezone('America/Caracas')->at('17:45');
        $schedule->command('sorteo:checkresult 5 46')->timezone('America/Caracas')->at('18:45');
        $schedule->command('sorteo:checkresult 5 47')->timezone('America/Caracas')->at('19:45');

        $schedule->command('sorteo:checkresult 6 48')->timezone('America/Caracas')->at('09:45');
        $schedule->command('sorteo:checkresult 6 49')->timezone('America/Caracas')->at('10:45');
        $schedule->command('sorteo:checkresult 6 50')->timezone('America/Caracas')->at('11:45');
        $schedule->command('sorteo:checkresult 6 51')->timezone('America/Caracas')->at('12:45');
        $schedule->command('sorteo:checkresult 6 52')->timezone('America/Caracas')->at('13:45');
        $schedule->command('sorteo:checkresult 6 53')->timezone('America/Caracas')->at('14:45');
        $schedule->command('sorteo:checkresult 6 54')->timezone('America/Caracas')->at('15:45');
        $schedule->command('sorteo:checkresult 6 55')->timezone('America/Caracas')->at('16:45');
        $schedule->command('sorteo:checkresult 6 56')->timezone('America/Caracas')->at('17:45');
        $schedule->command('sorteo:checkresult 6 57')->timezone('America/Caracas')->at('18:45');
        $schedule->command('sorteo:checkresult 6 58')->timezone('America/Caracas')->at('19:45');

        // chance con animalitos
        $schedule->command('sorteo:checkresult 7 59')->timezone('America/Caracas')->at('09:15');
        $schedule->command('sorteo:checkresult 7 60')->timezone('America/Caracas')->at('10:15');
        $schedule->command('sorteo:checkresult 7 61')->timezone('America/Caracas')->at('11:15');
        $schedule->command('sorteo:checkresult 7 62')->timezone('America/Caracas')->at('12:15');
        $schedule->command('sorteo:checkresult 7 63')->timezone('America/Caracas')->at('13:15');
        $schedule->command('sorteo:checkresult 7 64')->timezone('America/Caracas')->at('14:15');
        $schedule->command('sorteo:checkresult 7 65')->timezone('America/Caracas')->at('15:15');
        $schedule->command('sorteo:checkresult 7 66')->timezone('America/Caracas')->at('16:15');
        $schedule->command('sorteo:checkresult 7 67')->timezone('America/Caracas')->at('17:15');
        $schedule->command('sorteo:checkresult 7 68')->timezone('America/Caracas')->at('18:15');
        $schedule->command('sorteo:checkresult 7 69')->timezone('America/Caracas')->at('19:15');


        $schedule->command('sorteo:checkresult 3 113')->timezone('America/Lima')->at('09:15');
        $schedule->command('sorteo:checkresult 3 114')->timezone('America/Lima')->at('10:15');
        $schedule->command('sorteo:checkresult 3 115')->timezone('America/Lima')->at('11:15');
        $schedule->command('sorteo:checkresult 3 116')->timezone('America/Lima')->at('12:15');
        $schedule->command('sorteo:checkresult 3 117')->timezone('America/Lima')->at('13:15');
        $schedule->command('sorteo:checkresult 3 118')->timezone('America/Lima')->at('14:15');
        $schedule->command('sorteo:checkresult 3 119')->timezone('America/Lima')->at('15:15');
        $schedule->command('sorteo:checkresult 3 120')->timezone('America/Lima')->at('16:15');
        $schedule->command('sorteo:checkresult 3 121')->timezone('America/Lima')->at('17:15');
        $schedule->command('sorteo:checkresult 3 122')->timezone('America/Lima')->at('18:15');
        $schedule->command('sorteo:checkresult 3 123')->timezone('America/Lima')->at('19:15');

        //  guacharo 

        $schedule->command('sorteo:checkresult 10 91')->timezone('America/Lima')->at('09:15');
        $schedule->command('sorteo:checkresult 10 92')->timezone('America/Lima')->at('10:15');
        $schedule->command('sorteo:checkresult 10 93')->timezone('America/Lima')->at('11:15');
        $schedule->command('sorteo:checkresult 10 94')->timezone('America/Lima')->at('12:15');
        $schedule->command('sorteo:checkresult 10 95')->timezone('America/Lima')->at('13:15');
        $schedule->command('sorteo:checkresult 10 96')->timezone('America/Lima')->at('14:15');
        $schedule->command('sorteo:checkresult 10 97')->timezone('America/Lima')->at('15:15');
        $schedule->command('sorteo:checkresult 10 98')->timezone('America/Lima')->at('16:15');
        $schedule->command('sorteo:checkresult 10 99')->timezone('America/Lima')->at('17:15');
        $schedule->command('sorteo:checkresult 10 100')->timezone('America/Lima')->at('18:15');
        $schedule->command('sorteo:checkresult 10 101')->timezone('America/Lima')->at('19:15');

        //  Selva Plus

        $schedule->command('sorteo:checkresult 11 102')->timezone('America/Lima')->at('09:15');
        $schedule->command('sorteo:checkresult 11 103')->timezone('America/Lima')->at('10:15');
        $schedule->command('sorteo:checkresult 11 104')->timezone('America/Lima')->at('11:15');
        $schedule->command('sorteo:checkresult 11 105')->timezone('America/Lima')->at('12:15');
        $schedule->command('sorteo:checkresult 11 106')->timezone('America/Lima')->at('13:15');
        $schedule->command('sorteo:checkresult 11 107')->timezone('America/Lima')->at('14:15');
        $schedule->command('sorteo:checkresult 11 108')->timezone('America/Lima')->at('15:15');
        $schedule->command('sorteo:checkresult 11 109')->timezone('America/Lima')->at('16:15');
        $schedule->command('sorteo:checkresult 11 110')->timezone('America/Lima')->at('17:15');
        $schedule->command('sorteo:checkresult 11 111')->timezone('America/Lima')->at('18:15');
        $schedule->command('sorteo:checkresult 11 112')->timezone('America/Lima')->at('19:15');

        //  Ruleta Activa

        $schedule->command('sorteo:checkresult 12 124')->timezone('America/Lima')->at('09:15');
        $schedule->command('sorteo:checkresult 12 125')->timezone('America/Lima')->at('10:15');
        $schedule->command('sorteo:checkresult 12 126')->timezone('America/Lima')->at('11:15');
        $schedule->command('sorteo:checkresult 12 127')->timezone('America/Lima')->at('12:15');
        $schedule->command('sorteo:checkresult 12 128')->timezone('America/Lima')->at('13:15');
        $schedule->command('sorteo:checkresult 12 129')->timezone('America/Lima')->at('14:15');
        $schedule->command('sorteo:checkresult 12 130')->timezone('America/Lima')->at('15:15');
        $schedule->command('sorteo:checkresult 12 131')->timezone('America/Lima')->at('16:15');
        $schedule->command('sorteo:checkresult 12 132')->timezone('America/Lima')->at('17:15');
        $schedule->command('sorteo:checkresult 12 133')->timezone('America/Lima')->at('18:15');
        $schedule->command('sorteo:checkresult 12 134')->timezone('America/Lima')->at('19:15');

        // LOTTO PLUS 

        $schedule->command('loko:default')->timezone('America/Caracas')->at('07:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('08:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('09:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('10:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('11:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('12:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('13:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('14:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('15:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('16:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('17:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('18:58');
        $schedule->command('loko:default')->timezone('America/Caracas')->at('19:58');

        $schedule->command('loko:close')->timezone('America/Caracas')->at('07:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('08:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('09:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('10:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('11:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('12:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('13:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('14:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('15:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('16:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('17:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('18:59');
        $schedule->command('loko:close')->timezone('America/Caracas')->at('19:59');

        $schedule->command('loko:close')->timezone('America/Caracas')->at('23:35'); // reiniciar loteria

        $schedule->command('loko:send')->timezone('America/Caracas')->at('08:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('09:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('10:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('11:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('12:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('13:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('14:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('15:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('16:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('17:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('18:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('19:01');
        $schedule->command('loko:send')->timezone('America/Caracas')->at('20:01');

        $schedule->command('loko:get')->timezone('America/Caracas')->at('08:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('09:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('10:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('11:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('12:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('13:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('14:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('15:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('16:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('17:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('18:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('19:05');
        $schedule->command('loko:get')->timezone('America/Caracas')->at('20:05');



        // $schedule->command('sorteo:set')->timezone('America/New_York')->at('2:00');

        // tripleta verificacion

        $schedule->command('tripleta:check 1 0')->timezone('America/Caracas')->at('09:20');
        $schedule->command('tripleta:check 1 1')->timezone('America/Caracas')->at('10:20');
        $schedule->command('tripleta:check 1 2')->timezone('America/Caracas')->at('11:20');
        $schedule->command('tripleta:check 1 3')->timezone('America/Caracas')->at('12:20');
        $schedule->command('tripleta:check 1 4')->timezone('America/Caracas')->at('13:20');
        $schedule->command('tripleta:check 1 5')->timezone('America/Caracas')->at('14:20');
        $schedule->command('tripleta:check 1 6')->timezone('America/Caracas')->at('15:20');
        $schedule->command('tripleta:check 1 7')->timezone('America/Caracas')->at('16:20');
        $schedule->command('tripleta:check 1 8')->timezone('America/Caracas')->at('17:20');
        $schedule->command('tripleta:check 1 9')->timezone('America/Caracas')->at('18:20');
        $schedule->command('tripleta:check 1 10')->timezone('America/Caracas')->at('19:20');

        $schedule->command('tripleta:check 4 0')->timezone('America/Caracas')->at('08:21');
        $schedule->command('tripleta:check 4 1')->timezone('America/Caracas')->at('09:21');
        $schedule->command('tripleta:check 4 2')->timezone('America/Caracas')->at('10:21');
        $schedule->command('tripleta:check 4 3')->timezone('America/Caracas')->at('11:21');
        $schedule->command('tripleta:check 4 4')->timezone('America/Caracas')->at('12:21');
        $schedule->command('tripleta:check 4 5')->timezone('America/Caracas')->at('13:21');
        $schedule->command('tripleta:check 4 6')->timezone('America/Caracas')->at('14:21');
        $schedule->command('tripleta:check 4 7')->timezone('America/Caracas')->at('15:21');
        $schedule->command('tripleta:check 4 8')->timezone('America/Caracas')->at('16:21');
        $schedule->command('tripleta:check 4 9')->timezone('America/Caracas')->at('17:21');
        $schedule->command('tripleta:check 4 10')->timezone('America/Caracas')->at('18:21');
        $schedule->command('tripleta:check 4 11')->timezone('America/Caracas')->at('19:21');
        $schedule->command('tripleta:check 4 12')->timezone('America/Caracas')->at('20:21');

        $schedule->command('tripleta:check 2 0')->timezone('America/Caracas')->at('08:22');
        $schedule->command('tripleta:check 2 1')->timezone('America/Caracas')->at('09:22');
        $schedule->command('tripleta:check 2 2')->timezone('America/Caracas')->at('10:22');
        $schedule->command('tripleta:check 2 3')->timezone('America/Caracas')->at('11:22');
        $schedule->command('tripleta:check 2 4')->timezone('America/Caracas')->at('12:22');
        $schedule->command('tripleta:check 2 5')->timezone('America/Caracas')->at('13:22');
        $schedule->command('tripleta:check 2 6')->timezone('America/Caracas')->at('14:22');
        $schedule->command('tripleta:check 2 7')->timezone('America/Caracas')->at('15:22');
        $schedule->command('tripleta:check 2 8')->timezone('America/Caracas')->at('16:22');
        $schedule->command('tripleta:check 2 9')->timezone('America/Caracas')->at('17:22');
        $schedule->command('tripleta:check 2 10')->timezone('America/Caracas')->at('18:22');
        $schedule->command('tripleta:check 2 11')->timezone('America/Caracas')->at('19:22');

        $schedule->command('tripleta:check 5 0')->timezone('America/Caracas')->at('08:52');
        $schedule->command('tripleta:check 5 1')->timezone('America/Caracas')->at('09:52');
        $schedule->command('tripleta:check 5 2')->timezone('America/Caracas')->at('10:52');
        $schedule->command('tripleta:check 5 3')->timezone('America/Caracas')->at('11:52');
        $schedule->command('tripleta:check 5 4')->timezone('America/Caracas')->at('12:52');
        $schedule->command('tripleta:check 5 5')->timezone('America/Caracas')->at('13:52');
        $schedule->command('tripleta:check 5 6')->timezone('America/Caracas')->at('14:52');
        $schedule->command('tripleta:check 5 7')->timezone('America/Caracas')->at('15:52');
        $schedule->command('tripleta:check 5 8')->timezone('America/Caracas')->at('16:52');
        $schedule->command('tripleta:check 5 9')->timezone('America/Caracas')->at('17:52');
        $schedule->command('tripleta:check 5 10')->timezone('America/Caracas')->at('18:52');
        $schedule->command('tripleta:check 5 11')->timezone('America/Caracas')->at('19:52');

        $schedule->command('tripleta:check 6 0')->timezone('America/Caracas')->at('09:44');
        $schedule->command('tripleta:check 6 1')->timezone('America/Caracas')->at('10:44');
        $schedule->command('tripleta:check 6 2')->timezone('America/Caracas')->at('11:44');
        $schedule->command('tripleta:check 6 3')->timezone('America/Caracas')->at('12:44');
        $schedule->command('tripleta:check 6 4')->timezone('America/Caracas')->at('13:44');
        $schedule->command('tripleta:check 6 5')->timezone('America/Caracas')->at('14:44');
        $schedule->command('tripleta:check 6 6')->timezone('America/Caracas')->at('15:44');
        $schedule->command('tripleta:check 6 7')->timezone('America/Caracas')->at('16:44');
        $schedule->command('tripleta:check 6 8')->timezone('America/Caracas')->at('17:44');
        $schedule->command('tripleta:check 6 9')->timezone('America/Caracas')->at('18:44');
        $schedule->command('tripleta:check 6 10')->timezone('America/Caracas')->at('19:44');

        $schedule->command('tripleta:check 7 0')->timezone('America/Caracas')->at('09:22');
        $schedule->command('tripleta:check 7 1')->timezone('America/Caracas')->at('10:22');
        $schedule->command('tripleta:check 7 2')->timezone('America/Caracas')->at('11:22');
        $schedule->command('tripleta:check 7 3')->timezone('America/Caracas')->at('12:22');
        $schedule->command('tripleta:check 7 4')->timezone('America/Caracas')->at('13:22');
        $schedule->command('tripleta:check 7 5')->timezone('America/Caracas')->at('14:22');
        $schedule->command('tripleta:check 7 6')->timezone('America/Caracas')->at('15:22');
        $schedule->command('tripleta:check 7 7')->timezone('America/Caracas')->at('16:22');
        $schedule->command('tripleta:check 7 8')->timezone('America/Caracas')->at('17:22');
        $schedule->command('tripleta:check 7 9')->timezone('America/Caracas')->at('18:22');
        $schedule->command('tripleta:check 7 10')->timezone('America/Caracas')->at('19:22');

        $schedule->command('tripleta:check 10 0')->timezone('America/Caracas')->at('09:23');
        $schedule->command('tripleta:check 10 1')->timezone('America/Caracas')->at('10:23');
        $schedule->command('tripleta:check 10 2')->timezone('America/Caracas')->at('11:23');
        $schedule->command('tripleta:check 10 3')->timezone('America/Caracas')->at('12:23');
        $schedule->command('tripleta:check 10 4')->timezone('America/Caracas')->at('13:23');
        $schedule->command('tripleta:check 10 5')->timezone('America/Caracas')->at('14:23');
        $schedule->command('tripleta:check 10 6')->timezone('America/Caracas')->at('15:23');
        $schedule->command('tripleta:check 10 7')->timezone('America/Caracas')->at('16:23');
        $schedule->command('tripleta:check 10 8')->timezone('America/Caracas')->at('17:23');
        $schedule->command('tripleta:check 10 9')->timezone('America/Caracas')->at('18:23');
        $schedule->command('tripleta:check 10 10')->timezone('America/Caracas')->at('19:23');

        $schedule->command('tripleta:check 11 0')->timezone('America/Caracas')->at('09:23');
        $schedule->command('tripleta:check 11 1')->timezone('America/Caracas')->at('10:23');
        $schedule->command('tripleta:check 11 2')->timezone('America/Caracas')->at('11:23');
        $schedule->command('tripleta:check 11 3')->timezone('America/Caracas')->at('12:23');
        $schedule->command('tripleta:check 11 4')->timezone('America/Caracas')->at('13:23');
        $schedule->command('tripleta:check 11 5')->timezone('America/Caracas')->at('14:23');
        $schedule->command('tripleta:check 11 6')->timezone('America/Caracas')->at('15:23');
        $schedule->command('tripleta:check 11 7')->timezone('America/Caracas')->at('16:23');
        $schedule->command('tripleta:check 11 8')->timezone('America/Caracas')->at('17:23');
        $schedule->command('tripleta:check 11 9')->timezone('America/Caracas')->at('18:23');
        $schedule->command('tripleta:check 11 10')->timezone('America/Caracas')->at('19:23');

        $schedule->command('tripleta:check 12 0')->timezone('America/Caracas')->at('09:24');
        $schedule->command('tripleta:check 12 1')->timezone('America/Caracas')->at('10:24');
        $schedule->command('tripleta:check 12 2')->timezone('America/Caracas')->at('11:24');
        $schedule->command('tripleta:check 12 3')->timezone('America/Caracas')->at('12:24');
        $schedule->command('tripleta:check 12 4')->timezone('America/Caracas')->at('13:24');
        $schedule->command('tripleta:check 12 5')->timezone('America/Caracas')->at('14:24');
        $schedule->command('tripleta:check 12 6')->timezone('America/Caracas')->at('15:24');
        $schedule->command('tripleta:check 12 7')->timezone('America/Caracas')->at('16:24');
        $schedule->command('tripleta:check 12 8')->timezone('America/Caracas')->at('17:24');
        $schedule->command('tripleta:check 12 9')->timezone('America/Caracas')->at('18:24');
        $schedule->command('tripleta:check 12 10')->timezone('America/Caracas')->at('19:24');



        // CERRAR ANIMALITOS 
        // NENECIO LOTTO ACTIVO
        // GRABIELA GOMEZ LOTTO ACTIVO

        // $schedule->command('sorteo:closeadmin 118 1 1')->timezone('America/Caracas')->at('08:50');
        // $schedule->command('sorteo:closeadmin 118 1 2')->timezone('America/Caracas')->at('09:50');
        // $schedule->command('sorteo:closeadmin 118 1 3')->timezone('America/Caracas')->at('10:50');
        // $schedule->command('sorteo:closeadmin 118 1 4')->timezone('America/Caracas')->at('11:50');
        // $schedule->command('sorteo:closeadmin 118 1 5')->timezone('America/Caracas')->at('12:50');
        // $schedule->command('sorteo:closeadmin 118 1 6')->timezone('America/Caracas')->at('13:50');
        // $schedule->command('sorteo:closeadmin 118 1 7')->timezone('America/Caracas')->at('14:50');
        // $schedule->command('sorteo:closeadmin 118 1 8')->timezone('America/Caracas')->at('15:50');
        // $schedule->command('sorteo:closeadmin 118 1 9')->timezone('America/Caracas')->at('16:50');
        // $schedule->command('sorteo:closeadmin 118 1 10')->timezone('America/Caracas')->at('17:50');
        // $schedule->command('sorteo:closeadmin 118 1 11')->timezone('America/Caracas')->at('18:50');

        // NENECIO LA GRANJITA
        // GRABIELA GOMEZ LA GRANJITA
        $schedule->command('sorteo:closeadmin 118 2 135')->timezone('America/Caracas')->at('07:45');
        $schedule->command('sorteo:closeadmin 118 2 136')->timezone('America/Caracas')->at('08:45');
        $schedule->command('sorteo:closeadmin 118 2 137')->timezone('America/Caracas')->at('09:45');
        $schedule->command('sorteo:closeadmin 118 2 138')->timezone('America/Caracas')->at('10:45');
        $schedule->command('sorteo:closeadmin 118 2 139')->timezone('America/Caracas')->at('11:45');
        $schedule->command('sorteo:closeadmin 118 2 140')->timezone('America/Caracas')->at('12:45');
        $schedule->command('sorteo:closeadmin 118 2 141')->timezone('America/Caracas')->at('13:45');
        $schedule->command('sorteo:closeadmin 118 2 142')->timezone('America/Caracas')->at('14:45');
        $schedule->command('sorteo:closeadmin 118 2 143')->timezone('America/Caracas')->at('15:45');
        $schedule->command('sorteo:closeadmin 118 2 144')->timezone('America/Caracas')->at('16:45');
        $schedule->command('sorteo:closeadmin 118 2 145')->timezone('America/Caracas')->at('17:45');
        $schedule->command('sorteo:closeadmin 118 2 146')->timezone('America/Caracas')->at('18:45');


        // CERRAR ANIMALITOS 
        // GEOR LOTTO ACTIVO
        // Yairet Rodríguez LOTTO ACTIVO

        // $schedule->command('sorteo:closeadmin 349 1 1')->timezone('America/Caracas')->at('08:40');
        // $schedule->command('sorteo:closeadmin 349 1 2')->timezone('America/Caracas')->at('09:40');
        // $schedule->command('sorteo:closeadmin 349 1 3')->timezone('America/Caracas')->at('10:40');
        // $schedule->command('sorteo:closeadmin 349 1 4')->timezone('America/Caracas')->at('11:40');
        // $schedule->command('sorteo:closeadmin 349 1 5')->timezone('America/Caracas')->at('12:40');
        // $schedule->command('sorteo:closeadmin 349 1 6')->timezone('America/Caracas')->at('13:40');
        // $schedule->command('sorteo:closeadmin 349 1 7')->timezone('America/Caracas')->at('14:40');
        // $schedule->command('sorteo:closeadmin 349 1 8')->timezone('America/Caracas')->at('15:40');
        // $schedule->command('sorteo:closeadmin 349 1 9')->timezone('America/Caracas')->at('16:40');
        // $schedule->command('sorteo:closeadmin 349 1 10')->timezone('America/Caracas')->at('17:40');
        // $schedule->command('sorteo:closeadmin 349 1 11')->timezone('America/Caracas')->at('18:40');

        // GEOR LA GRANJITA
        // Yairet Rodríguez LA GRANJITA
        // $schedule->command('sorteo:closeadmin 349 2 135')->timezone('America/Caracas')->at('07:40');
        // $schedule->command('sorteo:closeadmin 349 2 136')->timezone('America/Caracas')->at('08:40');
        // $schedule->command('sorteo:closeadmin 349 2 137')->timezone('America/Caracas')->at('09:40');
        // $schedule->command('sorteo:closeadmin 349 2 138')->timezone('America/Caracas')->at('10:40');
        // $schedule->command('sorteo:closeadmin 349 2 139')->timezone('America/Caracas')->at('11:40');
        // $schedule->command('sorteo:closeadmin 349 2 140')->timezone('America/Caracas')->at('12:40');
        // $schedule->command('sorteo:closeadmin 349 2 141')->timezone('America/Caracas')->at('13:40');
        // $schedule->command('sorteo:closeadmin 349 2 142')->timezone('America/Caracas')->at('14:40');
        // $schedule->command('sorteo:closeadmin 349 2 143')->timezone('America/Caracas')->at('15:40');
        // $schedule->command('sorteo:closeadmin 349 2 144')->timezone('America/Caracas')->at('16:40');
        // $schedule->command('sorteo:closeadmin 349 2 145')->timezone('America/Caracas')->at('17:40');
        // $schedule->command('sorteo:closeadmin 349 2 146')->timezone('America/Caracas')->at('18:40');

        // CERRAR ANIMALITOS 
        // FIVIP LOTTO ACTIVO
        // Yenni Ramirez LOTTO ACTIVO

        // $schedule->command('sorteo:closeadmin 583 1 1')->timezone('America/Caracas')->at('08:40');
        // $schedule->command('sorteo:closeadmin 583 1 2')->timezone('America/Caracas')->at('09:40');
        // $schedule->command('sorteo:closeadmin 583 1 3')->timezone('America/Caracas')->at('10:40');
        // $schedule->command('sorteo:closeadmin 583 1 4')->timezone('America/Caracas')->at('11:40');
        // $schedule->command('sorteo:closeadmin 583 1 5')->timezone('America/Caracas')->at('12:40');
        // $schedule->command('sorteo:closeadmin 583 1 6')->timezone('America/Caracas')->at('13:40');
        // $schedule->command('sorteo:closeadmin 583 1 7')->timezone('America/Caracas')->at('14:40');
        // $schedule->command('sorteo:closeadmin 583 1 8')->timezone('America/Caracas')->at('15:40');
        // $schedule->command('sorteo:closeadmin 583 1 9')->timezone('America/Caracas')->at('16:40');
        // $schedule->command('sorteo:closeadmin 583 1 10')->timezone('America/Caracas')->at('17:40');
        // $schedule->command('sorteo:closeadmin 583 1 11')->timezone('America/Caracas')->at('18:40');

        // // FIVIP LA GRANJITA
        // // Yenni Ramirez LA GRANJITA
        // $schedule->command('sorteo:closeadmin 583 2 135')->timezone('America/Caracas')->at('07:40');
        // $schedule->command('sorteo:closeadmin 583 2 136')->timezone('America/Caracas')->at('08:40');
        // $schedule->command('sorteo:closeadmin 583 2 137')->timezone('America/Caracas')->at('09:40');
        // $schedule->command('sorteo:closeadmin 583 2 138')->timezone('America/Caracas')->at('10:40');
        // $schedule->command('sorteo:closeadmin 583 2 139')->timezone('America/Caracas')->at('11:40');
        // $schedule->command('sorteo:closeadmin 583 2 140')->timezone('America/Caracas')->at('12:40');
        // $schedule->command('sorteo:closeadmin 583 2 141')->timezone('America/Caracas')->at('13:40');
        // $schedule->command('sorteo:closeadmin 583 2 142')->timezone('America/Caracas')->at('14:40');
        // $schedule->command('sorteo:closeadmin 583 2 143')->timezone('America/Caracas')->at('15:40');
        // $schedule->command('sorteo:closeadmin 583 2 144')->timezone('America/Caracas')->at('16:40');
        // $schedule->command('sorteo:closeadmin 583 2 145')->timezone('America/Caracas')->at('17:40');
        // $schedule->command('sorteo:closeadmin 583 2 146')->timezone('America/Caracas')->at('18:40');

        $schedule->command('sorteo:filtracion')->cron('30-55/2 11-22 * * *');

        $schedule->command('sorteo:promedio')->cron('01-59/25 11-22 * * *');

        // reiniciar todos los limites
        $schedule->command('sorteo:clearadmin')->timezone('America/Caracas')->at('20:45');
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
