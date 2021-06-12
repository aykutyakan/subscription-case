<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurchaseWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:expired {limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resolve expired deactived subscription';

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
        $this->info("Fetching Task From Server...");
        
        $provider = $this->argument('limit');
        return 0;
    }
}
