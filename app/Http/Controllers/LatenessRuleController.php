<?php

namespace App\Http\Controllers;

use App\Models\LatenessRule;
use Illuminate\Http\Request;

class LatenessRuleController extends Controller
{
    public function index()
    {
        $this->authorize('القاعدة العامة'); // صلاحية عرض القواعد

        $rules = LatenessRule::orderBy('from_minutes')->get();
        return view('lateness_rules.lateness_rules', compact('rules'));
    }

    public function store(Request $request)
    {
        $this->authorize('اضافة قاعدة تأخير'); // صلاحية إضافة قاعدة

        $request->validate([
            'from_minutes' => 'required|integer|min:0',
            'to_minutes' => 'required|integer|gte:from_minutes',
            'deduction_type' => 'required|string',
            'deduction_value' => 'required|numeric|min:0',
            'early_leave_type' => 'nullable|string',
            'early_leave_value' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        LatenessRule::create($request->all());
        return redirect()->route('lateness_rules.index')->with('success','تمت إضافة القاعدة بنجاح');
    }

    public function update(Request $request, LatenessRule $lateness_rule)
    {
        $this->authorize('تعديل قاعدة تأخير'); // صلاحية تعديل قاعدة

        $request->validate([
            'from_minutes' => 'required|integer|min:0',
            'to_minutes' => 'required|integer|gte:from_minutes',
            'deduction_type' => 'required|string',
            'deduction_value' => 'required|numeric|min:0',
            'early_leave_type' => 'nullable|string',
            'early_leave_value' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $lateness_rule->update($request->all());
        return redirect()->route('lateness_rules.index')->with('success','تم تعديل القاعدة بنجاح');
    }

    public function destroy(LatenessRule $lateness_rule)
    {
        $this->authorize('حذف قاعدة تأخير'); // صلاحية حذف قاعدة

        $lateness_rule->delete();
        return redirect()->route('lateness_rules.index')->with('success','تم حذف القاعدة بنجاح');
    }
}
