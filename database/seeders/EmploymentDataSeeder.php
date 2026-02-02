<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmpData;
use App\Models\emp_employment; // تأكد من استدعاء الموديل الصحيح

class EmploymentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = EmpData::all();

        if ($employees->isEmpty()) {
            $this->command->info('لا يوجد موظفين لإضافة بيانات التوظيف.');
            return;
        }

        foreach ($employees as $emp) {
            emp_employment::firstOrCreate(
                ['emp_id' => $emp->id], // الآن البحث في جدول employment_data
                [
                    'basic_salary' => rand(5000, 15000),
                    'insured' => rand(0, 1),
                    'insurance_date' => now()->subYears(rand(0,5))->format('Y-m-d'),
                    'insurance_rate' => rand(5, 15),
                    'insurance_amount' => rand(500, 2000),
                    'insurance_number' => 'INS'.rand(1000,9999),
                    'created_by' => 'Admin',
                ]
            );
        }

        $this->command->info('تمت إضافة بيانات التوظيف للموظفين.');
    }
}
