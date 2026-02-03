<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpData;
use App\Models\AttendanceLog;
use App\Models\EmployeeShift;
use App\Models\departments;
use Carbon\Carbon;
    use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendancePeriodExport;
use App\Models\Organization;

class AttendanceReportController extends Controller
{
    // شاشة اختيار الفلاتر لتقرير الفترة
    public function filters()
    {
        $departments = departments::all();
        $employees   = EmpData::where('status', 'نشط')->get();

        return view('reports.attendance.attendance_filters', compact('departments','employees'));
    }

    // عرض تقرير الفترة بعد اختيار الفلاتر
    public function results(Request $request)
    {
        $departmentId = $request->department_id;
        $jobId        = $request->job_id;
        $employeeId   = $request->employee_id;
        $fromDate     = $request->from_date ? Carbon::parse($request->from_date) : null;
        $toDate       = $request->to_date ? Carbon::parse($request->to_date) : null;

        if(!$fromDate || !$toDate) {
            return redirect()->back()->with('error', 'يجب تحديد من تاريخ وإلى تاريخ.');
        }

        // جلب الموظفين حسب الفلاتر
        $employees = EmpData::query()->where('status','نشط');
        if($departmentId && $departmentId !== 'all') $employees->where('department_id', $departmentId);
        if($jobId && $jobId !== 'all') $employees->where('job_id', $jobId);
        if($employeeId && $employeeId !== 'all') $employees->where('id', $employeeId);

        $employees = $employees->get();

        // إنشاء تقرير الفترة
        $report = $this->periodReport($employees, $fromDate, $toDate);

            // ✅ زر تصدير Excel
    if($request->has('export_excel')) {
        return Excel::download(new AttendancePeriodExport($report), 'attendance_report.xlsx');
    }
    
        // جلب بيانات المنشأة
        $organization = Organization::first(); // أو حسب اختيارك
        return view('reports.attendance.period_report', compact('report','fromDate','toDate','organization'));
    }

    // تقرير الفترة لكل موظف
    private function periodReport($employees, $fromDate, $toDate)
    {
        $report = [];

        // توليد أيام الفترة
        $period = Carbon::parse($fromDate)->daysUntil(Carbon::parse($toDate));

        foreach($employees as $emp) {
            $employeeReport = [];

            foreach($period as $date) {
                $shift = EmployeeShift::where('emp_data_id', $emp->id)
                    ->where('from_date', '<=', $date)
                    ->where('to_date', '>=', $date)
                    ->first();

                $shiftStart = $shift ? $shift->shift->start_time : null;
                $shiftEnd = $shift ? $shift->shift->end_time : null;

                $logs = AttendanceLog::where('emp_data_id', $emp->id)
                    ->where('log_date', $date)
                    ->get();

                $timeIn  = $logs->where('type','in')->sortBy('log_time')->first()?->log_time ?? null;
                $timeOut = $logs->where('type','out')->sortByDesc('log_time')->first()?->log_time ?? null;

                // حساب ساعات العمل
                $hoursWorked = ($timeIn && $timeOut) ? Carbon::parse($timeIn)->diffInHours(Carbon::parse($timeOut)) : 0;

                // حساب التأخير بالدقائق (إذا وقت الدخول بعد وقت بداية الورديه)
                $late = 0;
                if($timeIn && $shiftStart){
                    $diff = Carbon::parse($timeIn)->diffInMinutes(Carbon::parse($shiftStart), false);
                    $late = $diff > 0 ? $diff : 0; // لو أكبر من صفر يبقى تأخير
                }
                // حساب الانصراف المبكر بالدقائق (إذا وقت الخروج قبل وقت نهاية الورديه)
                $earlyLeave = 0;

if ($timeOut && $shiftEnd) {
    $shiftEndCarbon = Carbon::parse($shiftEnd);
    $timeOutCarbon  = Carbon::parse($timeOut);

    if ($timeOutCarbon->lt($shiftEndCarbon)) {
        $earlyLeave = $timeOutCarbon->diffInMinutes($shiftEndCarbon);
    }
    
}

                $status = ($timeIn && $timeOut) ? 'حاضر' : 'غياب';

          $employeeReport[] = [
    'date'            => $date->toDateString(),
    'employee_id'     => $emp->id,
    'employee_name'   => $emp->full_name,
    'department_name' => $emp->department?->department_name ?? '-',
    'job_name'        => $emp->job?->job_name ?? '-',
    'shift'           => $shift ? $shift->shift->name : '-',
    'start_time'     => $shift ? $shift->shift->start_time : '-',
     'end_time'        => $shift ? $shift->shift->end_time : '-', 
    'time_in'         => $timeIn ?? '-',
    'time_out'        => $timeOut ?? '-',
    'hours_worked'    => $hoursWorked,
    'late_minutes'    => $late,
    'early_leave' => $earlyLeave,
    'status'          => $status,
    'attendance_id'   => $logs->first()?->id ?? null,
];

            }

            $report[$emp->id] = $employeeReport;
        }

        return $report;
    }

    // طباعة تقرير موظف معين للفترة
    public function print($employee_id, $from_date, $to_date)
    {
        $emp = EmpData::findOrFail($employee_id);
        $fromDate = Carbon::parse($from_date);
        $toDate   = Carbon::parse($to_date);

        $report = $this->periodReport(collect([$emp]), $fromDate, $toDate);

        return view('reports.attendance.print_report', compact('report','fromDate','toDate','emp'));
    }




}
