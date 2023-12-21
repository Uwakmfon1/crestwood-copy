<?php

namespace App\Console\Commands;

use App\Http\Controllers\CommandController;
use Illuminate\Console\Command;

class TransactionNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email to admin to attend to pending transactions';

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
        CommandController::transactionNotify();
    }
}
