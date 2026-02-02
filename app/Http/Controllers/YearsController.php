<?php

namespace App\Http\Controllers;

use App\Models\Years;
use Illuminate\Http\Request;

class YearsController extends Controller
{
    // عرض كل السنين
    public function index()
    {
        $this->authorize('عرض السنين');

        $years = Years::all();
        return view('years.years', compact('years'));
    }

    // حفظ سنة جديدة
    public function store(Request $request)
    {
        $this->authorize('اضافة سنة');

        $request->validate([
            'year' => 'required|unique:years|max:255',
        ], [
            'year.unique' => 'خطأ: السنة مسجلة مسبقاً',
            'year.required' => 'اسم السنة مطلوب',
            'year.max' => 'اسم السنة طويل جداً',
        ]);

        Years::create(['year' => $request->year]);
        session()->flash('Add', 'تم إضافة السنة بنجاح');
        return redirect()->route('years.index');
    }

    public function create()
    {
        $this->authorize('اضافة سنة');
        //
    }

    public function show(Years $year)
    {
        $this->authorize('عرض السنين');
        //
    }

    public function edit(Years $year)
    {
        $this->authorize('تعديل سنة');

        return view('years.edit', compact('year'));
    }

    // تعديل سنة موجودة
    public function update(Request $request, Years $year)
    {
        $this->authorize('تعديل سنة');

        $request->validate([
            'year' => 'required|string|max:255|unique:years,year,' . $year->id,
        ], [
            'year.unique' => 'خطأ: السنة مسجلة مسبقاً',
            'year.required' => 'اسم السنة مطلوب',
            'year.max' => 'اسم السنة طويل جداً',
        ]);

        $year->update(['year' => $request->year]);
        session()->flash('edit', 'تم تحديث السنة بنجاح');
        return redirect()->route('years.index');
    }

    // حذف سنة
    public function destroy(Years $year)
    {
        $this->authorize('حذف سنة');

        $year->delete();
        session()->flash('delete', 'تم حذف السنة بنجاح');
        return redirect()->route('years.index');
    }
}
