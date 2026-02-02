<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpData;
use App\Models\AttendanceLog;

class AttendanceLogController extends Controller
{
    // صفحة عرض السجلات
    public function index()
    {
        $this->authorize('عرض سجلات الحضور'); // صلاحية عرض السجلات
        return view('attendance.attendance');
    }

    // فلترة DataTables
    public function filter(Request $request)
    {
        // لو مش موجود صلاحية، ارجع array فاضي بدل Forbidden
       

        $query = AttendanceLog::with(['employee','device']);

        if($request->emp_id){
            $query->where('emp_data_id', $request->emp_id);
        }

        if($request->from_date){
            $query->whereDate('log_date', '>=', $request->from_date);
        }

        if($request->to_date){
            $query->whereDate('log_date', '<=', $request->to_date);
        }

        $logs = $query->orderBy('log_date','desc')->get();

        $data = $logs->map(function($log){
            return [
                'employee_name' => $log->employee->full_name ?? ($log->employee->name ?? '-'),
                'employee_number' => $log->employee->emp_number ?? ($log->employee->employee_code ?? '-'),
                'device_ip'     => $log->device->ip_address ?? '-',
                'type'          => ucfirst($log->type ?? '-'),
                'log_date'      => $log->log_date ?? '-',
                'log_time'      => $log->log_time ?? '-',
            ];
        });

        // رجع array مباشر عشان DataTables ما يعملش Invalid JSON
        return response()->json($data);
    }

    // بحث الموظف للـ autocomplete
    public function searchEmployee(Request $request)
    {
        $search = $request->get('search','');

        $employees = EmpData::where('full_name','like',"%{$search}%")
            ->orWhere('emp_number','like',"%{$search}%")
            ->get(['id','full_name','emp_number']);

        return response()->json($employees);
    }
}
