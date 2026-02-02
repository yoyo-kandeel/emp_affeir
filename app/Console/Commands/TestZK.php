<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ZKTecoService;

class TestZK extends Command
{
    protected $signature = 'zk:test';
    protected $description = 'Test ZKTeco connection';

    public function handle(ZKTecoService $zk)
    {
        $logs = $zk->getAttendance();

        dd($logs); // يعرض السجلات ويتأكد إن الاتصال شغال
    }
}
