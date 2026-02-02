<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Years;

class YearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startYear = 2024;
        $endYear   = 2030; // عدّل حسب الحاجة

        for ($year = $startYear; $year <= $endYear; $year++) {
            Years::firstOrCreate([
                'year' => $year
            ]);
        }

        $this->command->info('تمت إضافة السنوات بنجاح.');
    }
}
