<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $this->authorize('عرض الورديات'); // صلاحية عرض قائمة الورديات

        $shifts = Shift::all();
        return view('shifts.shifts', compact('shifts'));
    }

    public function store(Request $request)
    {
        $this->authorize('إضافة وردية'); // صلاحية إضافة وردية

        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Shift::create($request->all());

        return redirect()->route('shifts.index')->with('success', 'تمت إضافة الوردية بنجاح');
    }

    public function update(Request $request, Shift $shift)
    {
        $this->authorize('تعديل وردية'); // صلاحية تعديل وردية

        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $shift->update($request->all());

        return redirect()->route('shifts.index')->with('success', 'تم تعديل الوردية بنجاح');
    }

    public function destroy(Shift $shift)
    {
        $this->authorize('حذف وردية'); // صلاحية حذف وردية

        $shift->delete();
        return redirect()->route('shifts.index')->with('success', 'تم حذف الوردية بنجاح');
    }
}
