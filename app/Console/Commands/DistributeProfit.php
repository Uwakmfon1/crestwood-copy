<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CommandController;

class DistributeProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investments:distribute-profits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute periodic ROI profits to users based on their investment ROI duration.';

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
        CommandController::distributeProfit($this);
    }
}
