<?php

namespace App\Console\Commands;

use App\Http\Controllers\CommandController;
use Illuminate\Console\Command;

class MarkEmailsFailed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:fail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark emails as failed';

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
        CommandController::markEmailsAsFailed();
    }
}
