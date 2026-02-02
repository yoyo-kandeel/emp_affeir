<?php

namespace App\Http\Controllers;

use App\Models\emp_employment;
use App\Models\departments;
use App\Models\jobs;
use App\Models\EmpData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpEmploymentController extends Controller
{
    /**
     * عرض كل بيانات التوظيف
     */
    public function index()
    {
        $this->authorize('عرض بيانات التوظيف');

        $departments = departments::all();
        $jobs = jobs::all();
        $employments = emp_employment::all();
        return view('emp_employment.emp_employment', compact('employments', 'departments', 'jobs'));
    }

    /**
     * نموذج إضافة توظيف جديد
     */
    public function create()
    {
        $this->authorize('اضافة بيانات التوظيف');

        return view('emp_employment.add_emp_employment');
    }

    /**
     * حفظ بيانات توظيف جديدة
     */
    public function store(Request $request)
    {
        $this->authorize('اضافة بيانات التوظيف');

        $request->validate([
            'emp_id'           => 'required|exists:emp_datas,id',
            'basic_salary'     => 'required|numeric|min:0',
            'insured'          => 'required|boolean',
            'insurance_date'   => 'nullable|date|required_if:insured,1',
            'insurance_rate'   => 'nullable|numeric|min:0|required_if:insured,1',
            'insurance_amount' => 'nullable|numeric|min:0|required_if:insured,1',
            'insurance_number' => 'nullable|string|required_if:insured,1',
        ]);

        if (emp_employment::where('emp_id', $request->emp_id)->exists()) {
            return redirect()->back()->withErrors([
                'emp_id' => 'هذا الموظف مسجل بالفعل في بيانات التوظيف'
            ]);
        }

        DB::transaction(function () use ($request) {
            emp_employment::create([
                'emp_id'            => $request->emp_id,
                'basic_salary'      => $request->basic_salary,
                'insured'           => $request->insured,
                'insurance_date'    => $request->insured ? $request->insurance_date : null,
                'insurance_rate'    => $request->insured ? $request->insurance_rate : null,
                'insurance_amount'  => $request->insured ? $request->insurance_amount : null,
                'insurance_number'  => $request->insured ? $request->insurance_number : null,
                'created_by'        => auth()->user()->name ?? 'admin',
            ]);

            EmpData::where('id', $request->emp_id)->update([
                'status' => 'نشط'
            ]);
        });

        session()->flash('success', 'تم حفظ بيانات التوظيف وتفعيل الموظف بنجاح');
        return redirect()->back();
    }

    /**
     * تصفية الموظفين حسب القسم والوظيفة (AJAX)
     */
    public function filter(Request $request)
    {
        $this->authorize('عرض بيانات التوظيف');

        if (!$request->department_id || !$request->job_id) {
            return response()->json([]);
        }

        $employees = EmpData::whereHas('emp_employment')
            ->where('department_id', $request->department_id)
            ->where('job_id', $request->job_id)
            ->with('emp_employment')
            ->get();

        $data = $employees->map(function ($emp) {
            $employment = $emp->emp_employment;

            return [
                'id'               => $employment->id,
                'emp_id'           => $emp->id,
                'full_name'        => $emp->full_name,
                'basic_salary'     => $employment->basic_salary,
                'insured'          => $employment->insured,
                'insurance_date'   => $employment->insurance_date,
                'insurance_rate'   => $employment->insurance_rate,
                'insurance_amount' => $employment->insurance_amount,
                'insurance_number' => $employment->insurance_number,
            ];
        });

        return response()->json($data);
    }

    /**
     * عرض تفاصيل توظيف موظف
     */
    public function show(emp_employment $emp_employment)
    {
        $this->authorize('عرض بيانات التوظيف');

        return view('emp_employment.details_emp_employment', compact('emp_employment'));
    }

    /**
     * نموذج تعديل توظيف موظف
     */
    public function edit(emp_employment $emp_employment)
    {
        $this->authorize('تعديل بيانات التوظيف');

        $emp_employment = emp_employment::findOrFail($emp_employment->id);
        return view('emp_employment.edit_emp_employment', compact('emp_employment'));
    }

    /**
     * تحديث بيانات التوظيف
     */
    public function update(Request $request, $id)
    {
        $this->authorize('تعديل بيانات التوظيف');

        $employment = emp_employment::findOrFail($id);

        $request->validate([
            'emp_id'           => 'required|exists:emp_datas,id',
            'basic_salary'     => 'required|numeric|min:0',
            'insured'          => 'required|boolean',
            'insurance_date'   => 'nullable|date',
            'insurance_rate'   => 'nullable|numeric|min:0',
            'insurance_amount' => 'nullable|numeric|min:0',
            'insurance_number' => 'nullable|numeric',
        ]);

        $employment->update([
            'emp_id'           => $request->emp_id,
            'basic_salary'     => $request->basic_salary,
            'insured'          => $request->insured,
            'insurance_date'   => $request->insurance_date,
            'insurance_rate'   => $request->insurance_rate,
            'insurance_amount' => $request->insurance_amount,
            'insurance_number' => $request->insurance_number,
        ]);

        session()->flash('success', 'تم تحديث بيانات التوظيف بنجاح');
        return redirect()->route('emp_employment.index');
    }

    /**
     * حذف بيانات توظيف موظف
     */
    public function destroy($id)
    {
        $this->authorize('حذف بيانات التوظيف');

        $employment = emp_employment::findOrFail($id);
        $employment->delete();

        session()->flash('success', 'تم حذف بيانات التوظيف بنجاح');
        return redirect()->route('emp_employment.index');
    }
}
