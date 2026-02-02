<?php

namespace App\Http\Controllers;

use App\Models\EmpPermission;
use App\Models\EmpData;
use App\Models\Years;
use App\Models\Months;
use App\Models\EmpDeduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmpPermissionController extends Controller
{
    /**
     * عرض الأذونات
     */
    public function index()
    {
        $this->authorize('عرض الأذونات');

        $years = Years::all();
        return view('emp_permissions.emp_permissions', compact('years'));
    }

    /**
     * فلترة الأذونات
     */
    public function filter(Request $request)
    {
        $this->authorize('عرض الأذونات');

        $permissions = EmpPermission::with('month')
            ->where('emp_data_id', $request->emp_id)
            ->where('month_id', $request->month_id)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'permission_type' => $p->permission_type,
                    'from_datetime' => $p->from_datetime,
                    'to_datetime' => $p->to_datetime,
                    'with_deduction' => $p->with_deduction,
                    'notes' => $p->notes,
                    'month_name' => $p->month->month_name,
                    'created_at' => $p->created_at->format('Y-m-d'),
                ];
            });

        return response()->json($permissions);
    }

    /**
     * جلب الشهور حسب السنة
     */
    public function getMonthsByYear(Request $request)
    {
        $this->authorize('عرض الأذونات');

        $months = Months::where('year_id', $request->year_id)->get();
        return response()->json($months);
    }

    /**
     * صفحة إضافة إذن
     */
    public function create()
    {
        $this->authorize('اضافة إذن');

        $years = Years::all();
        $months = Months::all();
        $employees = EmpData::where('status', 'نشط')->get();

        return view('emp_permissions.add_emp_permissions', compact('years', 'months', 'employees'));
    }

    /**
     * حفظ إذن جديد
     */
    public function store(Request $request)
    {
        $this->authorize('اضافة إذن');

        $request->validate([
            'emp_data_id'     => 'required|exists:emp_datas,id',
            'year_id'         => 'required|exists:years,id',
            'month_id'        => 'required|exists:months,id',
            'permission_type' => 'required|in:1,2,3',
            'from_datetime' => 'nullable|date',
            'to_datetime'   => 'nullable|date|after:from_datetime',
            'with_deduction'  => 'required|boolean',
            'permission_date' => 'required|date',
            'notes'           => 'nullable|string',
        ]);
$fromDatetime = $request->from_datetime;
$toDatetime   = $request->to_datetime;

/* لو غياب = يوم كامل */
if ($request->permission_type == 2) {
    $fromDatetime = Carbon::parse($request->permission_date)->startOfDay();
    $toDatetime   = Carbon::parse($request->permission_date)->endOfDay();
}

        $permission = EmpPermission::create([
            'emp_data_id'     => $request->emp_data_id,
            'year_id'         => $request->year_id,
            'month_id'        => $request->month_id,
            'permission_type' => $request->permission_type,
            'permission_date' => $request->permission_date,
            'from_datetime'   => $fromDatetime,
            'to_datetime'     => $toDatetime,
            'with_deduction'  => $request->with_deduction,
            'notes'           => $request->notes,
            'created_by'      => Auth::user()->name ?? null,
        ]);

        /* إنشاء خصم لو بخصم (مع منع التكرار) */
        if ($request->with_deduction == 1) {

            $exists = EmpDeduction::where('emp_data_id', $request->emp_data_id)
                ->where('year_id', $request->year_id)
                ->where('month_id', $request->month_id)
                ->where('deduction_type', $request->permission_type)
                ->whereDate('created_at', $request->permission_date)
                ->exists();

            if (!$exists) {
                $quantity = 0;

                if ($request->permission_type == 2) {
                    $quantity = 1; // غياب
                }

                if (in_array($request->permission_type, [1, 3])) {
                    $from = Carbon::parse($request->from_datetime);
                    $to   = Carbon::parse($request->to_datetime);
                    $quantity = $from->diffInMinutes($to) / 60;
                }

                EmpDeduction::create([
                    'emp_data_id'    => $request->emp_data_id,
                    'year_id'        => $request->year_id,
                    'month_id'       => $request->month_id,
                    'deduction_type' => $request->permission_type,
                    'quantity'       => $quantity,
                    'created_by'     => Auth::user()->name ?? null,
                ]);
            }
        }

        return redirect()->route('emp_permissions.index')
            ->with('success', 'تم إضافة الإذن بنجاح');
    }

    /**
     * صفحة تعديل إذن
     */
    public function edit(EmpPermission $empPermission)
    {
        $this->authorize('تعديل إذن');

        $years = Years::all();
        $months = Months::where('year_id', $empPermission->year_id)->get();
        $employees = EmpData::where('status', 'نشط')->get();

        return view('emp_permissions.edit_emp_permissions',
            compact('empPermission', 'years', 'months', 'employees'));
    }

    /**
     * تحديث إذن
     */
    public function update(Request $request, EmpPermission $empPermission)
    {
        $this->authorize('تعديل إذن');

        $request->validate([
            'emp_data_id'     => 'required|exists:emp_datas,id',
            'year_id'         => 'required|exists:years,id',
            'month_id'        => 'required|exists:months,id',
            'permission_type' => 'required|in:1,2,3',
            'from_datetime'   => 'required|date',
            'to_datetime'     => 'required|date|after:from_datetime',
            'with_deduction'  => 'required|boolean',
            'permission_date' => 'required|date',
            'notes'           => 'nullable|string',
        ]);

        /* حذف الخصم القديم */
        EmpDeduction::where('emp_data_id', $empPermission->emp_data_id)
            ->where('year_id', $empPermission->year_id)
            ->where('month_id', $empPermission->month_id)
            ->where('deduction_type', $empPermission->permission_type)
            ->whereDate('created_at', $empPermission->permission_date)
            ->delete();

        $empPermission->update([
            'emp_data_id'     => $request->emp_data_id,
            'year_id'         => $request->year_id,
            'month_id'        => $request->month_id,
            'permission_type' => $request->permission_type,
            'permission_date' => $request->permission_date,
            'from_datetime'   => $request->from_datetime,
            'to_datetime'     => $request->to_datetime,
            'with_deduction'  => $request->with_deduction,
            'notes'           => $request->notes,
            'created_by'      => Auth::user()->name ?? null,
        ]);

        /* إنشاء خصم جديد لو بخصم */
        if ($request->with_deduction == 1) {

            $quantity = 0;

            if ($request->permission_type == 2) {
                $quantity = 1;
            }

            if (in_array($request->permission_type, [1, 3])) {
                $from = Carbon::parse($request->from_datetime);
                $to   = Carbon::parse($request->to_datetime);
                $quantity = $from->diffInMinutes($to) / 60;
            }

            EmpDeduction::create([
                'emp_data_id'    => $request->emp_data_id,
                'year_id'        => $request->year_id,
                'month_id'       => $request->month_id,
                'deduction_type' => $request->permission_type,
                'quantity'       => $quantity,
                'created_by'     => Auth::user()->name ?? null,
            ]);
        }

        return redirect()->route('emp_permissions.index')
            ->with('success', 'تم تحديث الإذن بنجاح');
    }

    /**
     * حذف إذن
     */
    public function destroy(EmpPermission $empPermission)
    {
        $this->authorize('حذف إذن');

        if ($empPermission->with_deduction == 1) {
            EmpDeduction::where('emp_data_id', $empPermission->emp_data_id)
                ->where('year_id', $empPermission->year_id)
                ->where('month_id', $empPermission->month_id)
                ->where('deduction_type', $empPermission->permission_type)
                ->whereDate('created_at', $empPermission->permission_date)
                ->delete();
        }

        $empPermission->delete();

        return redirect()->route('emp_permissions.index')
            ->with('success', 'تم حذف الإذن بنجاح');
    }
}
