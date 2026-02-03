<?php

namespace App\Http\Controllers;

use App\Models\EmpAllowance;
use App\Models\Months;
use App\Models\Years;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpAllowancesController extends Controller
{
    /**
     * عرض صفحة البدلات
     */
    public function index()
    {
        $this->authorize('عرض البدلات'); // التحقق من صلاحية عرض البدلات

        $allowances = EmpAllowance::with(['year', 'month'])->get();
        $years  = Years::all();
        $months = Months::all();

        return view('allowances.allowances', compact('allowances', 'years', 'months'));
    }
/**
 * عرض صفحة إضافة بدل جديد
 */
public function create()
{
    $this->authorize('اضافة بدل'); // التحقق من صلاحية إضافة بدل

    $years  = Years::all();
    $months = Months::all();

    return view('allowances.add_allowances', compact('years', 'months'));
}
    /**
     * إضافة بدل جديد
     */
    public function store(Request $request)
    {
        $this->authorize('اضافة بدل'); // التحقق من صلاحية إضافة بدل

        $request->validate([
            'allowance_name' => 'required|string|max:255',
            'year_id'        => 'required|exists:years,id',
            'month_id'       => 'required|exists:months,id',
        ]);

        EmpAllowance::create([
            'allowance_name' => $request->allowance_name,
            'description'    => $request->description,
            'year_id'        => $request->year_id,
            'month_id'       => $request->month_id,
            'created_by'     => Auth::user()->name ?? null,
        ]);

        return redirect()->route('allowances.index')->with('success', 'تم إضافة البدل بنجاح');
    }


/**
 * عرض صفحة تعديل بدل
 */
public function edit($id)
{
    $this->authorize('تعديل بدل'); // التحقق من صلاحية تعديل بدل

    $allowance = EmpAllowance::findOrFail($id);
    $years     = Years::all();
    $months    = Months::all();

    return view('allowances.edit_allowances', compact('allowance', 'years', 'months'));
}

    /**
     * تعديل بدل
     */
    public function update(Request $request, $id)
    {
        $this->authorize('تعديل بدل'); // التحقق من صلاحية تعديل بدل

        $request->validate([
            'allowance_name' => 'required|string|max:255',
            'year_id'        => 'required|exists:years,id',
            'month_id'       => 'required|exists:months,id',
        ]);

        $allowance = EmpAllowance::findOrFail($id);

        $allowance->update([
            'allowance_name' => $request->allowance_name,
            'description'    => $request->description,
            'year_id'        => $request->year_id,
            'month_id'       => $request->month_id,
        ]);

        return redirect()->route('allowances.index')->with('success', 'تم تعديل البدل بنجاح');
    }

    /**
     * حذف بدل (Soft Delete)
     */
    public function destroy($id)
    {
        $this->authorize('حذف بدل'); // التحقق من صلاحية حذف بدل

        $allowance = EmpAllowance::findOrFail($id);
        $allowance->delete();

        return redirect()->route('allowances.index')->with('success', 'تم حذف البدل بنجاح');
    }
}
