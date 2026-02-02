<?php

namespace App\Jobs;

use App\Models\FingerprintDevice;
use App\Services\ZKTecoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullFingerprintLogsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $device;

    /**
     * Create a new job instance.
     */
    public function __construct(FingerprintDevice $device)
    {
        $this->device = $device;
    }

    /**
     * Execute the job.
     */
    public function handle(ZKTecoService $service)
    {
        $result = $service->pullLogs($this->device);

        // حفظ النتيجة في Log لتتبع العمليات
        \Log::info("Pull logs for device {$this->device->ip_address}: ".$result['message']);
    }
}
