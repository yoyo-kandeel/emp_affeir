<?php

namespace App\Exports;

use App\Models\EmpData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
     * جلب جميع بيانات الموظفين
     */
    public function collection()
    {
        return EmpData::select(
            'emp_number',
            'full_name',
            'english_name',
            'birth_date',
            'birth_place',
            'gender',
            'religion',
            'nationality',
            'marital_status',
            'national_id',
            'phone',
            'address',
            'department_id',
            'job_id',
            'print_id',
            'hire_date',
            'status',
            'computer_skills',
            'english_proficiency',
            'certificate',
            'notes',
            'profile_image',
            'status_service',
            'experience',
            'children_count'
        )->get();
    }

    /**
     * رؤوس الأعمدة في Excel بالعربي
     */
    public function headings(): array
    {
        return [
            'رقم الموظف',
            'الاسم الكامل',
            'الاسم بالإنجليزي',
            'تاريخ الميلاد',
            'مكان الميلاد',
            'النوع',
            'الديانة',
            'الجنسية',
            'الحالة الاجتماعية',
            'الرقم القومي',
            'رقم الهاتف',
            'العنوان',
            'الإدارة',
            'الوظيفة',
            'كود البصمة',
            'تاريخ التعيين',
            'الحالة',
            'إجادة الكمبيوتر',
            'مستوى اللغة الإنجليزية',
            'الشهادة',
            'الملاحظات',
            'صورة الشخصية',
            'الموقف من التجنيد',
            'الخبرات السابقة',
            'عدد الأطفال'
        ];
    }
}
