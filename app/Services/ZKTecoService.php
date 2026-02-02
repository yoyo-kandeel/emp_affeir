<?php

namespace App\Services;

use Rats\Zkteco\Lib\ZKTeco;
use App\Models\AttendanceLog;
use App\Models\EmpData;
use Carbon\Carbon;

class ZKTecoService
{
    public function getZKInstance($device)
    {
        return new ZKTeco($device->ip_address, $device->port ?? 4370);
    }

    public function pullLogs($device)
    {
        $zk = $this->getZKInstance($device);

        if (!$zk->connect()) {
            return ['status'=>false, 'message'=>"الجهاز {$device->ip_address} غير متصل ❌"];
        }

        $attendance = $zk->getAttendance();
        $count = 0;

        $lastLog = AttendanceLog::where('fingerprint_device_id', $device->id)
                    ->orderBy('log_date','desc')
                    ->orderBy('log_time','desc')
                    ->first();

        foreach ($attendance as $log) {
            $timestamp = Carbon::parse($log['timestamp']);

            if ($lastLog && 
                ($timestamp->toDateString() < $lastLog->log_date ||
                 ($timestamp->toDateString() == $lastLog->log_date && $timestamp->format('H:i:s') <= $lastLog->log_time))
            ) continue;

            $emp = EmpData::where('print_id', $log['uid'])->first();
            if (!$emp) continue;

            AttendanceLog::create([
                'emp_data_id' => $emp->id,
                'fingerprint_device_id' => $device->id,
                'print_id' => $log['uid'],
                'log_date' => $timestamp->toDateString(),
                'log_time' => $timestamp->format('H:i:s'),
                'type' => $this->detectType($emp->id, $timestamp->toDateString()),
            ]);

            $count++;
        }

        $zk->disconnect();

        return ['status'=>true, 'message'=>"تم سحب $count سجل جديد من الجهاز {$device->ip_address} ✅"];
    }

    private function detectType($empId, $date)
    {
        $count = AttendanceLog::where('emp_data_id', $empId)
                    ->where('log_date', $date)
                    ->count();

        return $count == 0 ? 'in' : 'out';
    }
}

