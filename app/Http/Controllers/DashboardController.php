<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpData;
use App\Models\EmpPermission;
use App\Models\EmpDeduction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ========================
        // فلترة الشهر والسنة
        // ========================
        $month1 = $request->month1 ?? now()->month;
        $year1  = $request->year1  ?? now()->year;

        $month2 = $request->month2;
        $year2  = $request->year2;

        // ========================
        // إحصائيات عامة
        // ========================
        $totalEmployees  = EmpData::count();
        $todayEmployees  = EmpData::whereDate('created_at', today())->count();
        $todayPermissions = EmpPermission::whereDate('created_at', today())->count();
        $latestEmployees = EmpData::latest()->take(5)->get();

        // ========================
        // دالة تجهيز بيانات الخصومات
        // ========================
        $prepareDeductions = function ($month, $year) {

            $deductions = EmpDeduction::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get();

            $types = [
                0 => 'غياب',
                1 => 'تأخير',
                2 => 'خصم'
            ];

            $weeks = [];
            $dataByType = [];

            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end   = $start->copy()->endOfMonth();

            $week = 1;
            $current = $start->copy();

            while ($current->lte($end)) {
                $weeks[] = 'الأسبوع ' . $week;

                foreach ($types as $id => $name) {
                    $total = $deductions->filter(function ($d) use ($id, $current) {
                        return $d->deduction_type == $id &&
                               ceil($d->created_at->day / 7) == ceil($current->day / 7);
                    })->sum('quantity');

                    $dataByType[$name][] = $total;
                }

                $current->addWeek();
                $week++;
            }

            return [$weeks, $dataByType];
        };

        // ========================
        // بيانات الشهر الأساسي
        // ========================
        [$weeks, $dataByType] = $prepareDeductions($month1, $year1);

        // ========================
        // مقارنة شهرين (اختياري)
        // ========================
        $compareData = null;
        if ($month2 && $year2) {
            [, $compareData] = $prepareDeductions($month2, $year2);
        }

        return view('dashboard', compact(
            'totalEmployees',
            'todayEmployees',
            'todayPermissions',
            'latestEmployees',
            'weeks',
            'dataByType',
            'compareData',
            'month1',
            'year1',
            'month2',
            'year2'
        ));
    }
    
}
