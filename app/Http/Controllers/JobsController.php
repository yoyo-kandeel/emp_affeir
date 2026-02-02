<?php

namespace App\Http\Controllers;

use App\Models\jobs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\departments;

class JobsController extends Controller
{
    // عرض قائمة الوظائف
    public function index()
    {
        $this->authorize('عرض الوظائف');

        $jobs = jobs::with('department')->get();
        $departments = departments::all();

        return view('jobs.jobs', compact('jobs', 'departments'));
    }

    // إضافة وظيفة جديدة
    public function store(Request $request)
    {
        $this->authorize('اضافة وظيفة');

        $request->validate([
            'job_name' => 'required|string|max:255|unique:jobs,job_name',
            'department_id'   => 'required|exists:departments,id',
            'description'  => 'nullable|string',
        ],[
            'job_name.required' => 'اسم الوظيفة مطلوب',
            'job_name.unique'   => 'اسم الوظيفة موجود بالفعل',
            'department_id.required'   => 'اسم القسم مطلوب',
        ]);

        jobs::create([
            'job_name' => $request->job_name,
            'department_id'   => $request->department_id,
            'description'  => $request->description,
        ]);

        session()->flash('success', 'تم إضافة الوظيفة بنجاح');
        return redirect()->back();
    }

    // تعديل الوظيفة
    public function update(Request $request, $id)
    {
        $this->authorize('تعديل وظيفة');

        $job = jobs::findOrFail($id);

        $request->validate([
            'job_name' => 'required|string|max:255|unique:jobs,job_name,' . $id,
            'department_id'   => 'required|exists:departments,id',
            'description'  => 'nullable|string',
        ],[
            'job_name.required' => 'اسم الوظيفة مطلوب',
            'job_name.unique'   => 'اسم الوظيفة موجود بالفعل',
            'department_id.required'   => 'اسم القسم مطلوب',
        ]);

        $job->update([
            'job_name' => $request->job_name,
            'department_id'   => $request->department_id,
            'description'  => $request->description,
        ]);

        session()->flash('success', 'تم تعديل الوظيفة بنجاح');
        return redirect()->back();
    }

    // حذف الوظيفة
    public function destroy($id)
    {
        $this->authorize('حذف وظيفة');

        jobs::findOrFail($id)->delete();

        session()->flash('success', 'تم حذف الوظيفة بنجاح');
        return redirect()->back();
    }
}
