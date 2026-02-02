<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\departments; // تأكد إن الموديل موجود

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'department_name' => 'الموارد البشرية',
                'description' => 'قسم الموارد البشرية',
                'created_by' => 'Admin',
            ],
            [
                'department_name' => 'الشؤون المالية',
                'description' => 'قسم الشؤون المالية والمحاسبة',
                'created_by' => 'Admin',
            ],
            [
                'department_name' => 'تكنولوجيا المعلومات',
                'description' => 'قسم تكنولوجيا المعلومات والدعم الفني',
                'created_by' => 'Admin',
            ],
            [
                'department_name' => 'الإنتاج',
                'description' => 'قسم الإنتاج والعمليات',
                'created_by' => 'Admin',
            ],
        ];

        foreach ($departments as $dept) {
            departments::firstOrCreate(
                ['department_name' => $dept['department_name']],
                $dept
            );
        }
    }
}
