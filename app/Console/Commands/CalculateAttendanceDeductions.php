<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmpData;
use App\Models\Shift;
use App\Models\EmployeeShift;
use App\Models\AttendanceLog;
use App\Models\LatenessRule;
use App\Models\Years;
use App\Models\Months;
use App\Models\EmpDeduction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CalculateAttendanceDeductions extends Command
{
    protected $signature = 'attendance:run_deductions
                            {from_date? : تاريخ البداية (اختياري)}
                            {to_date? : تاريخ النهاية (اختياري)}
                            {--preview : فقط عرض التقرير بدون الحفظ}';

    protected $description = 'حساب خصومات الحضور والانصراف والغياب للموظفين مع تراكم الخصومات لكل شهر';

    public function handle()
    {
        $from = $this->argument('from_date') ? Carbon::parse($this->argument('from_date'))->startOfDay() : now()->startOfMonth();
        $to   = $this->argument('to_date') ? Carbon::parse($this->argument('to_date'))->endOfDay() : now()->endOfMonth();

        $employees = EmpData::all();

        $this->info("✅ بدء الحساب من {$from->toDateString()} إلى {$to->toDateString()}");

        foreach ($employees as $emp) {
            $empShifts = EmployeeShift::where('emp_data_id', $emp->id)
                ->where('to_date', '>=', $from->toDateString())
                ->where('from_date', '<=', $to->toDateString())
                ->get();

            if ($empShifts->isEmpty()) {
                $this->line("  - {$emp->full_name} : لا يوجد ورديات في الفترة المحددة");
                continue;
            }

            foreach ($empShifts as $empShift) {
                $workDays = json_decode($empShift->work_days, true) ?? [];

                // تحديد الفترة حسب الوردية والفترة المطلوبة
                $period = CarbonPeriod::create(
                    max($empShift->from_date, $from->toDateString()), 
                    min($empShift->to_date, $to->toDateString())
                );

                $shift = Shift::find($empShift->shift_id);

                foreach ($period as $day) {
                    $dayName = $day->format('l'); // Monday, Tuesday...

                    // إذا اليوم ليس ضمن أيام العمل
                    if (!in_array($dayName, $workDays)) {
                        $this->line("📅 {$day->toDateString()} - {$emp->full_name} : يوم عطلة (ليس ضمن أيام العمل)");
                        continue;
                    }

                    $attendanceIn = AttendanceLog::where('emp_data_id', $emp->id)
                        ->whereDate('log_date', $day->toDateString())
                        ->where('type', 'in')
                        ->first();

                    $attendanceOut = AttendanceLog::where('emp_data_id', $emp->id)
                        ->whereDate('log_date', $day->toDateString())
                        ->where('type', 'out')
                        ->first();

                    $year = Years::firstOrCreate(['year' => $day->year]);
                    $month = Months::firstOrCreate(['month_number' => $day->month]);

                    // ======= تسجيل التأخير =======
                    $minutesLate = 0;
                    $lateMsg = '-';
                    if ($attendanceIn) {
                        $shiftStart = Carbon::parse($day->toDateString() . ' ' . $shift->start_time);
                        $minutesLate = Carbon::parse($attendanceIn->log_date . ' ' . $attendanceIn->log_time)
                            ->greaterThan($shiftStart) 
                            ? Carbon::parse($attendanceIn->log_date . ' ' . $attendanceIn->log_time)
                                ->diffInMinutes($shiftStart) 
                            : 0;

                        $rule = LatenessRule::where('from_minutes', '<=', $minutesLate)
                            ->where('to_minutes', '>=', $minutesLate)
                            ->where('is_active', 1)
                            ->first();

                        $lateMsg = $minutesLate > 0 && $rule 
                            ? "{$rule->deduction_value} ({$rule->deduction_type})" 
                            : ($minutesLate > 0 ? "لا يوجد خصم" : '-');

                        if (!$this->option('preview') && $minutesLate > 0 && $rule) {
                            $deduction = EmpDeduction::firstOrCreate([
                                'emp_data_id'    => $emp->id,
                                'year_id'        => $year->id,
                                'month_id'       => $month->id,
                                'deduction_type' => 'تأخير',
                            ], [
                                'quantity'   => 0,
                                'created_by' => 1,
                            ]);

                            $deduction->increment('quantity', $rule->deduction_value);
                        }
                    }

                    // ======= تسجيل الانصراف المبكر =======
                    $earlyMinutes = 0;
                    $earlyMsg = '-';
                    if ($attendanceOut) {
                        $shiftEnd = Carbon::parse($day->toDateString() . ' ' . $shift->end_time);
                        $earlyMinutes = Carbon::parse($attendanceOut->log_date . ' ' . $attendanceOut->log_time)
                            ->lessThan($shiftEnd) 
                            ? $shiftEnd->diffInMinutes(Carbon::parse($attendanceOut->log_date . ' ' . $attendanceOut->log_time)) 
                            : 0;

                        $earlyRule = LatenessRule::where('from_minutes', '<=', $earlyMinutes)
                            ->where('to_minutes', '>=', $earlyMinutes)
                            ->where('is_active', 1)
                            ->first();

                        $earlyMsg = $earlyMinutes > 0 && $earlyRule 
                            ? "{$earlyRule->deduction_value} ({$earlyRule->deduction_type})" 
                            : ($earlyMinutes > 0 ? "لا يوجد خصم" : '-');

                        if (!$this->option('preview') && $earlyMinutes > 0 && $earlyRule) {
                            $deduction = EmpDeduction::firstOrCreate([
                                'emp_data_id'    => $emp->id,
                                'year_id'        => $year->id,
                                'month_id'       => $month->id,
                                'deduction_type' => 'انصراف مبكر',
                            ], [
                                'quantity'   => 0,
                                'created_by' => 1,
                            ]);

                            $deduction->increment('quantity', $earlyRule->deduction_value);
                        }
                    }

                    // ======= تسجيل الغياب =======
                    if (!$attendanceIn && !$attendanceOut) {
                        if (!$this->option('preview')) {
                            $deduction = EmpDeduction::firstOrCreate([
                                'emp_data_id'    => $emp->id,
                                'year_id'        => $year->id,
                                'month_id'       => $month->id,
                                'deduction_type' => 'غياب',
                            ], [
                                'quantity'   => 0,
                                'created_by' => 1,
                            ]);

                            $deduction->increment('quantity');
                        }
                        $this->line("📅 {$day->toDateString()} - {$emp->full_name} : غياب ✅");
                    }

                    // حالة الحضور
                    $attendanceStatus = $attendanceIn || $attendanceOut ? 'مسجل' : 'غياب';
                    $this->line("📅 {$day->toDateString()} - {$emp->full_name} | وردية: {$shift->name} | حضور: {$attendanceStatus} | تأخير: {$minutesLate} | خصم: {$lateMsg} | انصراف مبكر: {$earlyMsg}");
                }
            }
        }

        $this->info("\n🎉 تم الانتهاء من الحساب.");
        if ($this->option('preview')) {
            $this->info("💡 الوضع: عرض التقرير فقط، لم يتم حفظ الخصومات.");
        }
    }
}
