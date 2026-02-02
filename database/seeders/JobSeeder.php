<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\departments;
use App\Models\jobs;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // احصل على كل الأقسام
        $departments = departments::all();

        if ($departments->isEmpty()) {
            $this->command->info('لا توجد أقسام لإضافة الوظائف.');
            return;
        }

        $jobs = [
            'الموارد البشرية' => ['موظف توظيف', 'مسؤول شؤون موظفين', 'مدير الموارد البشرية'],
            'الشؤون المالية' => ['محاسب', 'محاسب أول', 'مدير مالي'],
            'تكنولوجيا المعلومات' => ['مبرمج', 'مدير نظم', 'فني دعم'],
            'الإنتاج' => ['مشرف إنتاج', 'عامل إنتاج', 'مدير إنتاج'],
        ];

        foreach ($jobs as $deptName => $jobNames) {
            $department = $departments->where('department_name', $deptName)->first();

            if ($department) {
                foreach ($jobNames as $jobName) {
                    jobs::firstOrCreate(
                        ['job_name' => $jobName, 'department_id' => $department->id],
                        [
                            'description' => $jobName . ' في قسم ' . $deptName,
                            'created_by' => 'Admin',
                        ]
                    );
                }
            }
        }

        $this->command->info('تمت إضافة الوظائف بنجاح.');
    }
}
