<?php

namespace App\Http\Controllers;

use App\Models\EmpDeduction;
use App\Models\EmpData;
use App\Models\Years;
use App\Models\Months;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DeductionNotification;
use App\Models\User;

class EmpDeductionsController extends Controller
{
    /**
     * عرض كل الخصومات مع السنين
     */
    public function index()
    {
        $this->authorize('عرض الخصومات');

        $years = Years::all();
        return view('emp_deductions.emp_deductions', compact('years'));
    }

    /**
     * فلترة الخصومات حسب الموظف والشهر
     */
    public function filter(Request $request)
    {
        $this->authorize('عرض الخصومات');

        $deductions = EmpDeduction::with(['month'])
            ->where('emp_data_id', $request->emp_id)
            ->where('month_id', $request->month_id)
            ->get()
            ->map(function($d){
                return [
                    'id' => $d->id,
                    'deduction_type' => $d->deduction_type,
                    'quantity' => $d->quantity,
                    'month_name' => $d->month->month_name,
                    'created_at' => $d->created_at->format('Y-m-d'),
                ];
            });

        return response()->json($deductions);
    }

    /**
     * جلب الشهور حسب السنة
     */
    public function getMonthsByYear(Request $request)
    {
        $this->authorize('عرض الخصومات');

        $months = Months::where('year_id', $request->year_id)->get();
        return response()->json($months);
    }

    /**
     * صفحة إضافة خصم
     */
    public function create()
    {
        $this->authorize('اضافة خصم');

        $years = Years::all();
        $months = Months::all();
        return view('emp_deductions.add_emp_deductions', compact('years', 'months'));
    }

    /**
     * حفظ خصم جديد
     */
    public function store(Request $request)
    {
        $this->authorize('اضافة خصم');

        $request->validate([
            'emp_id' => 'required|exists:emp_datas,id',
            'year_id' => 'required|exists:years,id',
            'month_id' => 'required|exists:months,id',
            'deduction_type' => 'required|in:0,1,2',
            'quantity' => 'required|numeric|min:0',
        ]);

        $deduction = EmpDeduction::create([
            'emp_data_id' => $request->emp_id,
            'year_id' => $request->year_id,
            'month_id' => $request->month_id,
            'deduction_type' => $request->deduction_type,
            'quantity' => $request->quantity,
            'created_by' => Auth::user()->name ?? null,
        ]);

        // إرسال إشعار لكل المستخدمين
        User::all()->each(fn($user) => $user->notify(new DeductionNotification($deduction)));

        return redirect()->route('emp_deductions.index')->with('success', 'تم إضافة الخصم بنجاح');
    }

    /**
     * صفحة تعديل الخصم
     */
    public function edit(EmpDeduction $empDeduction)
    {
        $this->authorize('تعديل خصم');

        $years = Years::all();
        $months = Months::where('year_id', $empDeduction->year_id)->get();
        $empDeduction->load('emp_data');

        return view('emp_deductions.edit_emp_deductions', compact('empDeduction', 'years', 'months'));
    }

    /**
     * تحديث الخصم
     */
    public function update(Request $request, EmpDeduction $empDeduction)
    {
        $this->authorize('تعديل خصم');

        $request->validate([
            'emp_id' => 'required|exists:emp_datas,id',
            'year_id' => 'required|exists:years,id',
            'month_id' => 'required|exists:months,id',
            'deduction_type' => 'required|in:0,1,2',
            'quantity' => 'required|numeric|min:0',
        ]);

        $empDeduction->update([
            'emp_data_id'    => $request->emp_id,
            'year_id'        => $request->year_id,
            'month_id'       => $request->month_id,
            'deduction_type' => $request->deduction_type,
            'quantity'       => $request->quantity,
            'created_by'     => Auth::user()->name ?? null,
        ]);

        return redirect()->route('emp_deductions.index')->with('success', 'تم تحديث الخصم بنجاح');
    }

    /**
     * حذف الخصم
     */
    public function destroy(EmpDeduction $empDeduction)
    {
        $this->authorize('حذف خصم');

        $empDeduction->delete();
        return redirect()->route('emp_deductions.index')->with('success', 'تم حذف الخصم بنجاح');
    }
}
