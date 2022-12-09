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
        Commands\CloserHorarioTropiGanaCommand::class
    ];

    protected function schedule(Schedule $schedule)
    {
        //  $schedule->command('exchange:dolarToday')->everyFourMinutes();
        //LA GRANJITA
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('08:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('09:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('10:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('11:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('12:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('13:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('14:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('15:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('16:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('17:40');
        $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('18:40');

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
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('08:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('09:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('10:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('11:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('12:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('13:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('14:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('15:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('16:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('17:21');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('18:21');

        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('03:55'); // reset lotto activo rd open all


        $schedule->command('sorteo:closelottorey')->timezone('America/Caracas')->at('08:20');
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
