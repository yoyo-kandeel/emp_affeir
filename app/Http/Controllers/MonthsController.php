<?php

namespace App\Http\Controllers;

use App\Models\Months;
use App\Models\Years;
use Illuminate\Http\Request;

class MonthsController extends Controller
{
    /**
     * عرض قائمة الشهور
     */
    public function index()
    {
        $this->authorize('عرض الشهور');

        $months = Months::with('year')
            ->orderBy('year_id')
            ->orderBy('month_number')
            ->get();

        $years = Years::all();

        return view('months.months', compact('months', 'years'));
    }

    /**
     * إضافة شهر جديد
     */
    public function store(Request $request)
    {
        $this->authorize('اضافة شهر');

        $validated = $request->validate([
            'month_name'   => 'required|string|max:255',
            'year_id'      => 'required|exists:years,id',
            'month_number' => 'required|integer|min:1|max:12',
        ], [
            'month_name.required'   => 'اسم الشهر مطلوب',
            'year_id.required'      => 'السنة مطلوبة',
            'month_number.required' => 'رقم الشهر مطلوب',
        ]);

        // منع تكرار نفس الشهر في نفس السنة
        $exists = Months::where('year_id', $validated['year_id'])
                        ->where('month_number', $validated['month_number'])
                        ->exists();

        if ($exists) {
            return back()->withErrors([
                'month_number' => 'هذا الرقم مستخدم لشهر آخر في نفس السنة'
            ]);
        }

        Months::create($validated);

        return back()->with('success', 'تم إضافة الشهر بنجاح');
    }

    /**
     * عرض صفحة التعديل
     */
    public function edit($id)
    {
        $this->authorize('تعديل شهر');

        $month = Months::findOrFail($id);
        $years = Years::all();

        return view('months.edit', compact('month', 'years'));
    }

    /**
     * حفظ التعديل
     */
    public function update(Request $request, $id)
    {
        $this->authorize('تعديل شهر');

        $month = Months::findOrFail($id);

        $validated = $request->validate([
            'month_name'   => 'required|string|max:255',
            'year_id'      => 'required|exists:years,id',
            'month_number' => 'required|integer|min:1|max:12',
        ]);

        // منع تكرار نفس الرقم في نفس السنة مع استثناء الشهر الحالي
        $exists = Months::where('year_id', $validated['year_id'])
                        ->where('month_number', $validated['month_number'])
                        ->where('id', '!=', $id)
                        ->exists();

        if ($exists) {
            return back()->withErrors([
                'month_number' => 'هذا الرقم مستخدم لشهر آخر في نفس السنة'
            ]);
        }

        $month->update($validated);

        return back()->with('success', 'تم تعديل الشهر بنجاح');
    }

    /**
     * حذف شهر
     */
    public function destroy($id)
    {
        $this->authorize('حذف شهر');

        $month = Months::findOrFail($id);
        $month->delete();

        return back()->with('success', 'تم حذف الشهر بنجاح');
    }

    /**
     * جلب الشهور حسب السنة (AJAX)
     */
    public function byYear(Request $request)
    {
        $months = Months::where('year_id', $request->year_id)
                        ->orderBy('month_number')
                        ->get(['id', 'month_name', 'month_number']);

        return response()->json($months);
    }
}
