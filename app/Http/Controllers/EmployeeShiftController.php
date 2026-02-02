<?php

namespace App\Http\Controllers;

use App\Models\EmpData;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeShiftController extends Controller
{
    // عرض جميع الورديات لكل الموظفين
    public function index()
    {
        $this->authorize('عرض الورديات'); // صلاحية عرض الورديات

        $employeeShifts = DB::table('employee_shift')
            ->join('emp_datas', 'employee_shift.emp_data_id', '=', 'emp_datas.id')
            ->join('shifts', 'employee_shift.shift_id', '=', 'shifts.id')
            ->select(
                'employee_shift.*',
                'emp_datas.full_name as employee_name',
                'shifts.name as shift_name'
            )
            ->orderBy('employee_shift.from_date', 'desc')
            ->get();

        $employees = EmpData::all();
        $shifts = Shift::all();

        return view('employee_shift.employee_shift', compact('employeeShifts', 'employees', 'shifts'));
    }

    // حفظ وردية جديدة (بفترة وأيام العمل)
    public function store(Request $request)
    {
        $this->authorize('إضافة وردية'); // صلاحية إضافة وردية

        $request->validate([
            'emp_data_id' => 'required|exists:emp_datas,id',
            'shift_id'    => 'required|exists:shifts,id',
            'from_date'   => 'required|date',
            'to_date'     => 'required|date|after_or_equal:from_date',
            'work_days'   => 'required|array|min:1',
        ]);

        // التحقق من تداخل الفترات لنفس الموظف
        $overlap = DB::table('employee_shift')
            ->where('emp_data_id', $request->emp_data_id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('from_date', [$request->from_date, $request->to_date])
                  ->orWhereBetween('to_date', [$request->from_date, $request->to_date])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('from_date', '<=', $request->from_date)
                         ->where('to_date', '>=', $request->to_date);
                  });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()
                ->with('error', 'هذا الموظف لديه وردية متداخلة في نفس الفترة');
        }

        DB::table('employee_shift')->insert([
            'emp_data_id' => $request->emp_data_id,
            'shift_id'    => $request->shift_id,
            'from_date'   => $request->from_date,
            'to_date'     => $request->to_date,
            'work_days'   => json_encode($request->work_days),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'تم إضافة الوردية بنجاح');
    }

    // تحديث وردية موجودة
    public function update(Request $request, $id)
    {
        $this->authorize('تعديل وردية'); // صلاحية تعديل وردية

        $request->validate([
            'emp_data_id' => 'required|exists:emp_datas,id',
            'shift_id'    => 'required|exists:shifts,id',
            'from_date'   => 'required|date',
            'to_date'     => 'required|date|after_or_equal:from_date',
            'work_days'   => 'required|array|min:1',
        ]);

        // منع التداخل (مع استثناء السجل الحالي)
        $overlap = DB::table('employee_shift')
            ->where('emp_data_id', $request->emp_data_id)
            ->where('id', '!=', $id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('from_date', [$request->from_date, $request->to_date])
                  ->orWhereBetween('to_date', [$request->from_date, $request->to_date])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('from_date', '<=', $request->from_date)
                         ->where('to_date', '>=', $request->to_date);
                  });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()
                ->with('error', 'هذا الموظف لديه وردية متداخلة في نفس الفترة');
        }

        DB::table('employee_shift')
            ->where('id', $id)
            ->update([
                'emp_data_id' => $request->emp_data_id,
                'shift_id'    => $request->shift_id,
                'from_date'   => $request->from_date,
                'to_date'     => $request->to_date,
                'work_days'   => json_encode($request->work_days),
                'updated_at'  => now(),
            ]);

        return redirect()->back()->with('success', 'تم تعديل الوردية بنجاح');
    }

    // حذف وردية
    public function destroy($id)
    {
        $this->authorize('حذف وردية'); // صلاحية حذف وردية
        DB::table('employee_shift')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'تم حذف الوردية');
    }
}
