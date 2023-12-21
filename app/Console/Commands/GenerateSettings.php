<?php

namespace App\Console\Commands;

use App\Http\Controllers\CommandController;
use App\Models\Setting;
use Illuminate\Console\Command;

class GenerateSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new setting for app when not found';

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
        CommandController::generateSettings();
    }
}
