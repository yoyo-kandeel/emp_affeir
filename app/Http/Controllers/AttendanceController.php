<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceLog;

use App\Models\EmpData;
use Illuminate\Support\Facades\Artisan;

class AttendanceController extends Controller
{
    // صفحة الفورم لتشغيل حساب الخصومات
    public function showForm()
    {
        return view('attendance.run_deductions'); // اسم الـ Blade الخاص بالفورم
    }

    // تسجيل الحضور
    public function checkIn(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:emp_datas,id',
            'date' => 'required|date',
        ]);

        Attendance::updateOrCreate(
            ['employee_id' => $request->employee_id, 'date' => $request->date],
            ['check_in' => now()]
        );

        return redirect()->back()->with('success','تم تسجيل الحضور');
    }

    // تسجيل الانصراف
    public function checkOut(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:emp_datas,id',
            'date' => 'required|date',
        ]);

        $attendance = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->first();

        if ($attendance) {
            $attendance->update(['check_out' => now()]);
            return redirect()->back()->with('success','تم تسجيل الانصراف');
        }

        return redirect()->back()->with('error','لم يتم تسجيل الحضور لهذا اليوم');
    }

    // عرض سجلات الحضور
    public function index()
    {
        $attendances = AttendanceLog::with('employee')
            ->orderBy('log_date','desc')
            ->paginate(50);

        return view('attendance.attendance', compact('attendances'));
    }

    // تشغيل حساب الخصومات

    // تشغيل الكوماند

    public function run(Request $request)
{
    $request->validate([
        'from_date' => 'nullable|date',
        'to_date'   => 'nullable|date|after_or_equal:from_date',
    ]);

    $from = $request->from_date ?: now()->startOfMonth()->toDateString();
    $to   = $request->to_date ?: now()->endOfMonth()->toDateString();

    Artisan::call('attendance:run_deductions', [
        'from_date' => $from,
        'to_date'   => $to,
    ]);

    $output = Artisan::output();

    return view('attendance.run_deductions', ['output' => $output]);
}


}
