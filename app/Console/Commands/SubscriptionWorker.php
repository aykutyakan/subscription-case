<?php

namespace App\Console\Commands;

use App\Jobs\CheckSubrscriptionExpireDateJob;
use App\Services\ResolveSubscription\ResolveSubscriptionManager;
use Illuminate\Console\Command;

class SubscriptionWorker extends Command
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
        $this->info("Ressolving Expired Subscription...");
        CheckSubrscriptionExpireDateJob::dispatch(100);
        return 0;
    }
}
