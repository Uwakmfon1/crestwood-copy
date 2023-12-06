<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\HomeController;
use App\Models\Setting;
use Illuminate\Console\Command;

class UpdateExhangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rate';

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
        CommandController::updateExchangeRate();
    }
}
