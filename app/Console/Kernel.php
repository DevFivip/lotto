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
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('08:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('09:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('10:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('11:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('12:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('13:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('14:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('15:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('16:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('17:40');
        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('18:40');

        $schedule->command('sorteo:closeselvaparaiso')->timezone('America/Lima')->at('03:47'); // reset selva paraiso


        // LOTTO ACTIVO RD
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('08:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('09:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('10:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('11:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('12:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('13:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('14:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('15:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('16:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('17:20');
        $schedule->command('sorteo:closelottoactivord')->timezone('America/Caracas')->at('18:20');

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
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('08:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('09:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('10:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('11:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('12:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('13:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('14:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('15:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('16:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('17:50');
        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('18:50');

        $schedule->command('sorteo:closechanceanimalitos')->timezone('America/Caracas')->at('03:56'); // reset granjita open all


        // Tropi Gana        
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('08:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('09:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('10:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('11:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('12:50');
        // $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('13:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('14:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('15:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('16:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('17:50');
        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('18:50');

        $schedule->command('sorteo:closetropigana')->timezone('America/Caracas')->at('03:57'); // reset granjita open all


        // JUNGLA MILLONARIA
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('08:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('09:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('10:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('11:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('12:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('13:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('14:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('15:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('16:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('17:50');
        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('18:50');

        $schedule->command('sorteo:closejunglamillonaria')->timezone('America/Caracas')->at('03:58'); // reset granjita open all


        // Guacharo Activo
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('08:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('09:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('10:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('11:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('12:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('13:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('14:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('15:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('16:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('17:50');
        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('18:50');

        $schedule->command('sorteo:closeguacharoactivo')->timezone('America/Caracas')->at('04:00'); // reset granjita open all


        // Selva Plus
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('08:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('09:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('10:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('11:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('12:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('13:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('14:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('15:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('16:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('17:50');
        $schedule->command('sorteo:closeselvaplus')->timezone('America/Caracas')->at('18:50');

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
