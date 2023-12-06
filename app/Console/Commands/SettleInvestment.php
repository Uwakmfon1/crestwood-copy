<?php

namespace App\Console\Commands;

use App\Http\Controllers\CommandController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Models\Investment;
use Illuminate\Console\Command;

class SettleInvestment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:settle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if investment return date has reached and settle';

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
        CommandController::settleInvestments();
    }
}
