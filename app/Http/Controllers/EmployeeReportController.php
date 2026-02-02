<?php

namespace App\Http\Controllers;

use App\Models\EmpData;
use App\Models\Department;
use App\Models\departments;
use App\Models\Job;
use App\Models\jobs;
use App\Models\Organization;
use Illuminate\Http\Request;

class EmployeeReportController extends Controller
{
    // شاشة اختيار الفلاتر
    public function filterPage()
    {
        $departments = departments::all();
        $jobs = jobs::all();
        $employees = EmpData::all();
        $organizations = Organization::all();

        return view('reports.employees.filters', compact('departments','jobs','employees','organizations'));
    }

    // شاشة النتائج بعد اختيار الفلاتر
    public function results(Request $request)
    {
        $query = EmpData::query();

        // فلترة حسب الإدارة
        if ($request->department_id && $request->department_id != 'all') {
            $query->where('department_id', $request->department_id);
        }

        // فلترة حسب الوظيفة
        if ($request->job_id && $request->job_id != 'all') {
            $query->where('job_id', $request->job_id);
        }

        // فلترة حسب الموظف
        if ($request->employee_id && $request->employee_id != 'all') {
            $query->where('id', $request->employee_id);
        }

        $employees = $query->get();

        // جلب بيانات المنشأة
        $organization = Organization::first(); // أو حسب اختيارك

        return view('reports.employees.results', compact('employees','organization','request'));
    }
}
