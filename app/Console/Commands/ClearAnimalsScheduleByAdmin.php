<?php

namespace App\Console\Commands;

use App\Models\UserAnimalitoSchedule;
use Illuminate\Console\Command;

class ClearAnimalsScheduleByAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:clearadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar todos los limites de los admin para comenzar el dia';

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

        UserAnimalitoSchedule::truncate();

        return 0;
    }
}
