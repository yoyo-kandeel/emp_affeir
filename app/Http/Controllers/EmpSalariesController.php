<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpSalary;
use App\Models\EmpData;
use App\Models\Years;
use App\Models\Months;
use App\Models\emp_employment;
use App\Models\EmpDeduction;

use App\Models\EmpAllowance;
use App\Models\SalaryAllowance;
use Illuminate\Support\Facades\DB;


class EmpSalariesController extends Controller
{


public function index(Request $request)
{

 $this->authorize('عرض الرواتب');  
    // لو الطلب Ajax → رجّع JSON فقط
    if ($request->ajax()) {

        // لو لسه مختارش سنة أو شهر
        if (!$request->year_id || !$request->month_id) {
            return response()->json([
                'data' => []
            ]);
        }

     $salaries = EmpSalary::with('emp')
    ->where('year_id', $request->year_id)
    ->where('month_id', $request->month_id)
    ->get()
    ->map(function ($salary) {
        return [
            'id'               => $salary->id,
            'employee'         => [
                'full_name' => optional($salary->emp)->full_name
            ],
            'basic_salary'     => $salary->basic_salary,
            'total_allowances' => $salary->total_allowances,
            'total_deductions' => $salary->total_deductions,
            'net_salary'       => $salary->net_salary,
        ];
    });


        return response()->json([
            'data' => $salaries
        ]);
    }

    // تحميل الصفحة العادي
    $years  = Years::all();
    $months = Months::all();

    return view('emp_salaries.emp_salaries', compact('years','months'));
}

public function data()
{
    return response()->json([
        'data' => EmpSalary::with('employee')->get()
    ]);
}

    // عرض كشف مرتب موظف محدد
    public function show($id)
    {
        $this->authorize(    'عرض كشف المرتبات',);
        $salary = EmpSalary::with(['emp','year','month','allowances.allowance'])->findOrFail($id);

        return view('emp_salaries.details_emp_salariest', compact('salary'));
    }

    // صفحة إضافة مرتب
    public function create()
    {
         $this->authorize('اضافة كشف مرتب');
        $years = Years::all();
        $allowances = EmpAllowance::all();
        return view('emp_salaries.add_emp_salaries', compact('years', 'allowances'));
    }

   
    // حفظ كشف مرتب
    public function store(Request $request)
    {
         $this->authorize('اضافة كشف مرتب');
        $request->validate([
            'emp_id'=>'required|exists:emp_datas,id',
            'year_id'=>'required|exists:years,id',
            'month_id'=>'required|exists:months,id',
            'basic_salary'=>'required|numeric',
        ]);

        DB::transaction(function() use($request){

            // جمع البيانات
            $basic_salary = $request->basic_salary;
            $working_days = $request->working_days ?? 30;
            $daily_rate = $basic_salary / $working_days;
            $hourly_rate = $daily_rate / 8;

            // الخصومات
            $deductions = EmpDeduction::where('emp_data_id',$request->emp_id)
                ->where('year_id',$request->year_id)
                ->where('month_id',$request->month_id)
                ->get()
                ->groupBy('deduction_type')
                ->map(fn($items)=> $items->sum('quantity'));

            $absence_days = $deductions[0] ?? 0;
            $delay_hours = $deductions[1] ?? 0;
            $penalties = $deductions[2] ?? 0;

            $total_deductions = ($absence_days * $daily_rate) + ($delay_hours * $hourly_rate) + $penalties;

            // التأمين
            $employment = emp_employment::where('emp_id',$request->emp_id)->first();
            $insurance_status = $employment->insured ?? false;
            $insurance_amount = $insurance_status ? ($employment->insurance_amount ?? 0) : 0;

            $total_deductions += $insurance_amount;

            // البدلات المرتبطة بالسنة والشهر
            $allowances_input = $request->allowances ?? [];
            $total_allowances = collect($allowances_input)->sum(fn($a)=> floatval($a['amount']));

            // صافي المرتب
            $net_salary = $basic_salary + $total_allowances - $total_deductions;

            // إنشاء المرتب
            $emp_salary = EmpSalary::create([
                'emp_id'=>$request->emp_id,
                'year_id'=>$request->year_id,
                'month_id'=>$request->month_id,
                'basic_salary'=>$basic_salary,
                'working_days'=>$working_days,
                'daily_rate'=>$daily_rate,
                'hourly_rate'=>$hourly_rate,
                'advance'=>$request->advance ?? 0,
                'insurance_status'=>$insurance_status,
                'insurance_amount'=>$insurance_amount,
                'absence_days'=>$absence_days,
                'delay_hours'=>$delay_hours,
                'penalties'=>$penalties,
                'total_deductions'=>$total_deductions,
                'total_allowances'=>$total_allowances,
                'net_salary'=>$net_salary,
                'payment_number'=>$request->payment_number ?? null,
            ]);

            // حفظ البدلات
            foreach($allowances_input as $a){
                if($a['id'] && floatval($a['amount']) > 0){
                    SalaryAllowance::create([
                        'emp_salary_id'=>$emp_salary->id,
                        'allowance_id'=>$a['id'],
                        'amount'=>$a['amount'],
                    ]);
                }
            }

        });

        return redirect()->route('emp_salaries.index')->with('success','تم حفظ كشف المرتب بنجاح');
    }

    // AJAX: جلب بيانات الموظف للمرتب
    public function getEmployeeData(Request $request)
    {
        $emp_id = $request->emp_id;
        $year_id = $request->year_id;
        $month_id = $request->month_id;

        $employee = EmpData::find($emp_id);
        if(!$employee) return response()->json(['error'=>'الموظف غير موجود']);

        // بيانات التوظيف
        $employment = emp_employment::where('emp_id', $emp_id)->first();
        $basic_salary = $employment->basic_salary ?? 0;
        $insured = $employment->insured ?? false;
        $insurance_amount = $insured ? ($employment->insurance_amount ?? 0) : 0;

        // الخصومات حسب النوع 0=غياب،1=تأخير،2=جزاء
        $deductions = EmpDeduction::where('emp_data_id', $emp_id)
                    ->where('year_id', $year_id)
                    ->where('month_id', $month_id)
                    ->get()
                    ->groupBy('deduction_type')
                    ->map(fn($items)=> $items->sum('quantity'));

        $absence_days = $deductions[0] ?? 0;
        $delay_hours = $deductions[1] ?? 0;
        $penalties = $deductions[2] ?? 0;

        // البدلات المرتبطة بالسنة والشهر
        $allowances = EmpAllowance::where('year_id',$year_id)
            ->where('month_id',$month_id)
            ->get()
            ->map(function($allow){
                return [
                    'id'=>$allow->id,
                    'name'=>$allow->allowance_name,
                    'amount'=>0
                ];
            });

      
return response()->json([
    'basic_salary' => $basic_salary,
    'insured' => $insured,
    'insurance_amount' => $insurance_amount,
    'deductions' => [
        'absence_days' => $absence_days,
        'delay_hours' => $delay_hours,
        'penalties' => $penalties,
    ],
    'allowances' => $allowances
]);
    }

public function edit($id)
{
      $this->authorize('تعديل كشف مرتب');
    $salary = EmpSalary::with([
        'emp',
        'year',
        'month',
        'allowances.allowance'
    ])->findOrFail($id);

    $years  = Years::all();
    $months = Months::all();

    return view('emp_salaries.edit_emp_salaries', compact('salary','years','months'));
}
public function editData($id)
{
          $this->authorize('تعديل كشف مرتب');

    $salary = EmpSalary::with([
        'allowances.allowance'
    ])->findOrFail($id);

    return response()->json([
        'emp_id'           => $salary->emp_id,
        'year_id'          => $salary->year_id,
        'month_id'         => $salary->month_id,
        'basic_salary'     => $salary->basic_salary,
        'working_days'     => $salary->working_days,
        'daily_rate'       => $salary->daily_rate,
        'hourly_rate'      => $salary->hourly_rate,
        'insurance_status' => $salary->insurance_status,
        'insurance_amount' => $salary->insurance_amount,
        'absence_days'     => $salary->absence_days,
        'delay_hours'      => $salary->delay_hours,
        'penalties'        => $salary->penalties,
        'total_deductions' => $salary->total_deductions,
        'total_allowances' => $salary->total_allowances,
        'net_salary'       => $salary->net_salary,

        'allowances' => $salary->allowances->map(function($a){
            return [
                'id'     => $a->allowance_id,
                'name'   => $a->allowance->allowance_name,
                'amount' => $a->amount
            ];
        })
    ]);
}
public function update(Request $request, $id)
{
          $this->authorize('تعديل كشف مرتب');

    $salary = EmpSalary::findOrFail($id);

    // احسب اليومي والساعة
    $working_days = $request->working_days ?? 30;
    $basic_salary = $request->basic_salary ?? 0;
    $daily_rate = $basic_salary / $working_days;
    $hourly_rate = $daily_rate / 8;

    // إجمالي الخصومات
    $absence = $request->absence_days ?? 0;
    $delay = $request->delay_hours ?? 0;
    $penalties = $request->penalties ?? 0;
    $insurance = ($request->insurance_status) ? ($request->insurance_amount ?? 0) : 0;

    $total_deductions = ($absence * $daily_rate) + ($delay * $hourly_rate) + $penalties + $insurance;

    // إجمالي البدلات
    $total_allowances = 0;
    if($request->allowances){
        foreach($request->allowances as $a){
            $total_allowances += $a['amount'] ?? 0;
        }
    }

    // صافي المرتب
    $net_salary = $basic_salary + $total_allowances - $total_deductions;

    // تحديث المرتب
    $salary->update([
        'basic_salary'     => $basic_salary,
        'working_days'     => $working_days,
        'daily_rate'       => $daily_rate,
        'hourly_rate'      => $hourly_rate,
        'absence_days'     => $absence,
        'delay_hours'      => $delay,
        'penalties'        => $penalties,
        'insurance_status' => $request->insurance_status ?? 0,
        'insurance_amount' => $request->insurance_amount ?? 0,
        'total_deductions' => $total_deductions,
        'total_allowances' => $total_allowances,
        'net_salary'       => $net_salary,
    ]);

    // تحديث البدلات
    $salary->allowances()->delete();
    if($request->allowances){
        foreach($request->allowances as $a){
            if($a['id']){
                $salary->allowances()->create([
                    'allowance_id' => $a['id'],
                    'amount' => $a['amount'] ?? 0
                ]);
            }
        }
    }

    return redirect()->route('emp_salaries.index')->with('success', 'تم تعديل المرتب بنجاح');
}





      public function destroy($id)
    {
              $this->authorize('حذف كشف مرتب');

        $salary = EmpSalary::findOrFail($id);
        $salary->delete();

        return redirect()->route('emp_salaries.index')->with('success','تم حذف كشف المرتب بنجاح');
    }
}