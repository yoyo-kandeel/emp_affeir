<?php


namespace App\Exports;

use App\Models\EmpDeduction;
use Maatwebsite\Excel\Concerns\FromCollection;

class DashboardExport implements FromCollection
{
    public function collection()
    {
        return EmpDeduction::select('deduction_type','quantity','created_at')->get();
    }
}
