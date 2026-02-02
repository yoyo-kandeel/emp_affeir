<?php

namespace App\Imports;

use App\Models\EmpData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new EmpData([
            'emp_number'        => $row['emp_number'],
            'full_name'         => $row['full_name'],
            'english_name'      => $row['english_name'] ?? null,
            'birth_date'        => $row['birth_date'] ?? null,
            'birth_place'       => $row['birth_place'] ?? null,
            'gender'            => $row['gender'] ?? null,
            'religion'          => $row['religion'] ?? null,
            'nationality'       => $row['nationality'] ?? null,
            'marital_status'    => $row['marital_status'] ?? null,
            'national_id'       => $row['national_id'],
            'phone'             => $row['phone'] ?? null,
            'address'           => $row['address'] ?? null,
            'department_id'     => $row['department_id'],
            'job_id'            => $row['job_id'],
            'print_id'          => $row['print_id'],
            'hire_date'         => $row['hire_date'] ?? null,
            'status'            => $row['status'] ?? 'نشط',
            'computer_skills'   => $row['computer_skills'] ?? null,
            'english_proficiency' => $row['english_proficiency'] ?? null,
            'certificate'       => $row['certificate'] ?? null,
            'notes'             => $row['notes'] ?? null,
            'profile_image'     => $row['profile_image'] ?? null, // ممكن تحط هنا اسم الصورة لو موجود
            'status_service'    => $row['status_service'] ?? null,
            'experience'        => $row['experience'] ?? null,
            'children_count'    => $row['children_count'] ?? 0,
            'created_by'        => auth()->user()->name,
        ]);
    }
}
