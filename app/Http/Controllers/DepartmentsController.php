<?php

namespace App\Http\Controllers;

use App\Models\departments;
use App\Http\Controllers\Controller;
use App\Models\jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DepartmentsController extends Controller
{
   public function index()
{
    $this->authorize('عرض الإدارات'); // التحقق من صلاحية عرض الإدارات

    $departments = departments::all();
    return view('departments.departments', compact('departments'));
}

public function store(Request $request)
{
    $this->authorize('اضافة إدارة'); // التحقق من صلاحية إضافة إدارة

    $request->validate([
        'department_name' => 'required|unique:departments|max:255',
        'description'     => 'nullable|max:255',
    ], [
        'department_name.unique'   => 'خطأ: الاداره مسجل مسبقاً',
        'department_name.required' => 'اسم الاداره مطلوب',
        'department_name.max'      => 'اسم الاداره طويل جداً',
        'description.max'          => 'الوصف طويل جداً',
    ]);

    departments::create([
        'department_name' => $request->department_name,
        'description'     => $request->description,
        'created_by'      => Auth::user()->name,
    ]);

    session()->flash('Add', 'تم إضافة الاداره بنجاح');
    return redirect()->route('departments.index');
}

public function edit(departments $department)
{
    $this->authorize('تعديل إدارة'); // التحقق من صلاحية تعديل إدارة
    return view('departments.edit', compact('department'));
}

public function update(Request $request, departments $department)
{
    $this->authorize('تعديل إدارة'); // التحقق من صلاحية تعديل إدارة

    $request->validate([
        'department_name' => 'required|string|max:255|unique:departments,department_name,' . $department->id,
        'description'     => 'nullable|string|max:255',
    ], [
        'department_name.unique'   => 'خطأ: الاداره مسجل مسبقاً',
        'department_name.required' => 'اسم الاداره مطلوب',
        'department_name.max'      => 'اسم الاداره طويل جداً',
        'description.max'          => 'الوصف طويل جداً',
    ]);

    $department->update([
        'department_name' => $request->department_name,
        'description'     => $request->description,
    ]);

    session()->flash('edit', 'تم تحديث الاداره بنجاح');
    return redirect()->route('departments.index');
}

public function destroy(departments $department)
{
    $this->authorize('حذف إدارة'); // التحقق من صلاحية حذف إدارة

    $department->delete();
    session()->flash('delete', 'تم حذف الاداره بنجاح');
    return redirect()->route('departments.index');
}

public function jobs($id)
{
    $this->authorize('عرض الإدارات'); // التحقق من صلاحية عرض الإدارات

    return jobs::where('department_id', $id)
        ->select('id', 'job_name')
        ->get();
}

}
