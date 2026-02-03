<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendancePeriodExport implements FromArray, WithHeadings
{
    protected $report;

    public function __construct(array $report)
    {
        $this->report = $report;
    }

    public function array(): array
    {
        // Flatten report if grouped by employeeId
        $flatReport = [];
        foreach($this->report as $employeeRecords){
            foreach($employeeRecords as $r){
                $flatReport[] = [
                    $r['date'],
                    $r['employee_name'],
                    $r['department_name'] ?? '-',
                    $r['job_name'] ?? '-',
                    $r['shift'],
                    $r['time_in'],
                    $r['time_out'],
                    $r['hours_worked'],
                    $r['late_minutes'],
                    $r['status'],
                ];
            }
        }
        return $flatReport;
    }

    public function headings(): array
    {
        return [
            'التاريخ',
            'اسم الموظف',
            'الإدارة',
            'الوظيفة',
            'الورديه',
            'وقت الدخول',
            'وقت الخروج',
            'عدد ساعات العمل',
            'التأخير بالدقائق',
            'الحالة',
        ];
    }
}
