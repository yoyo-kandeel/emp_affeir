<?php

namespace App\Http\Controllers;

use App\Models\departments;
use App\Models\jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentsController extends Controller
{
    // ===== عرض الإدارات =====
    public function index()
    {
        $this->authorize('عرض الإدارات');

        $departments = departments::all();
        return view('departments.departments', compact('departments'));
    }

    // ===== صفحة إضافة إدارة =====
    public function create()
    {
        $this->authorize('اضافة إدارة');

        return view('departments.add_departments');
    }

    // ===== حفظ الإدارة =====
    public function store(Request $request)
    {
        $this->authorize('اضافة إدارة');

        $request->validate([
            'department_name' => 'required|unique:departments|max:255',
            'description'     => 'nullable|max:255',
        ], [
            'department_name.required' => 'اسم الإدارة مطلوب',
            'department_name.unique'   => 'الإدارة مسجلة مسبقًا',
            'department_name.max'      => 'اسم الإدارة طويل جدًا',
            'description.max'          => 'الوصف طويل جدًا',
        ]);

        departments::create([
            'department_name' => $request->department_name,
            'description'     => $request->description,
            'created_by'      => Auth::user()->name,
        ]);

        session()->flash('Add', 'تم إضافة الإدارة بنجاح');
        return redirect()->route('departments.index');
    }

    // ===== صفحة تعديل إدارة =====
    public function edit(departments $department)
    {
        $this->authorize('تعديل إدارة');

        return view('departments.edit_departments', compact('department'));
    }

    // ===== تحديث الإدارة =====
    public function update(Request $request, departments $department)
    {
        $this->authorize('تعديل إدارة');

        $request->validate([
            'department_name' => 'required|max:255|unique:departments,department_name,' . $department->id,
            'description'     => 'nullable|max:255',
        ], [
            'department_name.required' => 'اسم الإدارة مطلوب',
            'department_name.unique'   => 'الإدارة مسجلة مسبقًا',
            'department_name.max'      => 'اسم الإدارة طويل جدًا',
            'description.max'          => 'الوصف طويل جدًا',
        ]);

        $department->update([
            'department_name' => $request->department_name,
            'description'     => $request->description,
        ]);

        session()->flash('edit', 'تم تحديث الإدارة بنجاح');
        return redirect()->route('departments.index');
    }

    // ===== حذف إدارة =====
    public function destroy(departments $department)
    {
        $this->authorize('حذف إدارة');

        $department->delete();
        session()->flash('delete', 'تم حذف الإدارة بنجاح');
        return redirect()->route('departments.index');
    }

    // ===== جلب الوظائف حسب الإدارة (AJAX) =====
    public function jobs($id)
    {
        $this->authorize('عرض الإدارات');

        return jobs::where('department_id', $id)
            ->select('id', 'job_name')
            ->get();
    }
}
