<?php

namespace App\Jobs;

use App\Services\ResolveSubscription\ResolveSubscriptionManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckSubrscriptionExpireDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $resolveSubscriptionManager;
    private $limit;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $limit)
    {
        $this->limit = $limit;
        $this->resolveSubscriptionManager = new ResolveSubscriptionManager();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->resolveSubscriptionManager
                ->resolveExpire($this->limit)
                ->verifySubscription();
    }
}
