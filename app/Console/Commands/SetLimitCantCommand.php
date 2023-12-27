<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetLimitCantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sorteo:setlimitcant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update animals set limit_cant = 100 where 1;';

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
        DB::select('update animals set limit_cant = 100 where ?', [1]);
        return 0;
    }
}
