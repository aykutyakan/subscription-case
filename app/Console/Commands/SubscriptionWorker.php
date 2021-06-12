<?php

namespace App\Console\Commands;

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
    private $resolveSubscriptionManager;
    public function __construct(ResolveSubscriptionManager $resolveSubscriptionManager)
    {
        parent::__construct();
        $this->resolveSubscriptionManager = $resolveSubscriptionManager;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Ressolving Expired Subscription...");
        
        $limit = $this->argument('limit');
        $this->resolveSubscriptionManager
                ->resolveExpire($limit)
                ->verifySubscription();
        return 0;
    }
}
