<?php

namespace App\Console\Commands;

use App\Models\Animal;
use App\Models\UserAnimalitoSchedule;
use Illuminate\Console\Command;

class CloseAnimalsScheduleByAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:closeadmin {admin_id} {loteria_id} {horario_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra los sorteos de los Administradores por hora ';

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
        $admin_id = $this->argument('admin_id');
        $loteria_id = $this->argument('loteria_id');
        $schedule_id = $this->argument('horario_id');

        $animals = Animal::where('sorteo_type_id', $loteria_id)->get();
        $animals = $animals->pluck('id');


        foreach ($animals as $animal_id) {
            $limit = 1;
            // dd($animal_id);
            // return 0;
            // validar si ya existe el registro 
            $fund  = UserAnimalitoSchedule::where('schedule_id', $schedule_id)->where('animal_id', $animal_id)->where('user_id', $admin_id)->first();
            // dd($fund);

            if ($fund == null) {
                if ($limit !== null) {
                    UserAnimalitoSchedule::create(['user_id' => $admin_id, 'schedule_id' => $schedule_id, 'animal_id' => $animal_id, 'limit' => $limit]);
                }
            } else {
                $fund->limit = $limit;
                $fund->update();
            }
        }


        return 0;
    }
}
