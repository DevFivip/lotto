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
        Commands\GetDolarTodayExchangeCommand::class,
        Commands\CloserHorarioLaGranjitaCommand::class
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('exchange:dolarToday')->everyFourMinutes();

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

         $schedule->command('sorteo:granjitaclose')->timezone('America/Caracas')->at('22:10'); // reset granjita open all



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
