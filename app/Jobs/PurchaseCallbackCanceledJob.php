<?php

namespace App\Jobs;

use App\Services\Callback\PurchaseCallbackEnum;
use App\Services\Callback\PurchaseCallbackFacede;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurchaseCallbackCanceledJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $deviceId;
    private $appId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($deviceId, $appId)
    {
        $this->deviceId = $deviceId;
        $this->appId    = $appId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        PurchaseCallbackFacede::handle($this->deviceId, $this->appId, PurchaseCallbackEnum::CANCELED);
    }
}
