<?php

namespace App\Http\Controllers;

use App\Models\departments;
use Illuminate\Http\Request;
use App\Models\EmpData;

class EmployeeStatusController extends Controller
{
    /**
     * عرض صفحة حالات الموظفين
     */
    public function index()
    {
        $this->authorize('عرض حالات الموظفين');

        $departments = departments::all();
        return view('emp_data.emp_status', compact('departments'));
    }

    /**
     * فلترة الموظفين (AJAX - DataTable)
     */
    public function filter(Request $request)
    {
        $this->authorize('عرض حالات الموظفين');

        $query = EmpData::query();

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->job_id) {
            $query->where('job_id', $request->job_id);
        }

        return response()->json(
            $query->select('id', 'full_name', 'status')->get()
        );
    }

    /**
     * تحديث حالة الموظف
     */
    public function updateStatus(Request $request, $id)
    {
        $this->authorize('تعديل حالة موظف');

        $request->validate([
            'status' => 'required'
        ]);

        $employee = EmpData::findOrFail($id);
        $employee->status = $request->status;
        $employee->save();

        session()->flash('success', 'تم تحديث حالة الموظف بنجاح');
        return redirect()->back();
    }
}
