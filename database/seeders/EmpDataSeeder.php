<?php

namespace Database\Seeders;

use App\Models\departments;
use Illuminate\Database\Seeder;
use App\Models\EmpData;

use App\Models\jobs;
use Illuminate\Support\Facades\DB;

class EmpDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // احصل على الأقسام والوظائف
        $departments = departments::all();
        $jobs = jobs::all();

        if ($departments->isEmpty() || $jobs->isEmpty()) {
            $this->command->info('يجب إضافة الأقسام والوظائف قبل إضافة الموظفين.');
            return;
        }

        $employees = [
            [
                'full_name' => 'أحمد محمد علي',
                'emp_number' => 1,
                'birth_date' => '1990-05-12',
                'gender' => 'ذكر',
                'nationality' => 'مصري',
                'marital_status' => 'متزوج',
                'children_count' => 2,
                'national_id' => '29005123456789',
                'phone' => '01012345678',
                'address' => 'القاهرة',
                'status_service' => 'معفى',
                'experience' => 'خبرة 5 سنوات',
                'certificate' => 'بكالوريوس',
                'hire_date' => '2015-03-01',
                'department_id' => $departments->random()->id,
                'job_id' => $jobs->random()->id,
                'status' => 'نشط',
                'notes' => 'موظف ممتاز',
                'profile_image' => null,
                'created_by' => 'Admin',
                'print_id' => 1,
                'english_name' => 'Ahmed Mohamed Ali',
                'computer_skills' => 'متقدم',
                'english_proficiency' => 'متوسط',
                'religion' => 'مسلم',
            ],
            [
                'full_name' => 'منى أحمد سعيد',
                'emp_number' => 2,
                'birth_date' => '1992-08-20',
                'gender' => 'أنثى',
                'nationality' => 'مصري',
                'marital_status' => 'أعزب',
                'children_count' => 0,
                'national_id' => '29208203456789',
                'phone' => '01123456789',
                'address' => 'الجيزة',
                'status_service' => 'معفاة',
                'experience' => 'خبرة 3 سنوات',
                'certificate' => 'ماجستير',
                'hire_date' => '2018-07-15',
                'department_id' => $departments->random()->id,
                'job_id' => $jobs->random()->id,
                'status' => 'نشط',
                'notes' => '',
                'profile_image' => null,
                'created_by' => 'Admin',
                'print_id' => 2,
                'english_name' => 'Mona Ahmed Said',
                'computer_skills' => 'متوسط',
                'english_proficiency' => 'جيد',
                'religion' => 'مسلمة',
            ],
            // ممكن تضيف هنا المزيد من الموظفين التجريبيين
        ];

        foreach ($employees as $emp) {
            EmpData::firstOrCreate(
                ['emp_number' => $emp['emp_number']], 
                $emp
            );
        }

        $this->command->info('تمت إضافة بيانات الموظفين بنجاح.');
    }
}
