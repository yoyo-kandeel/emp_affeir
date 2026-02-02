<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Years;
use App\Models\Months;

class MonthsSeeder extends Seeder
{
    public function run(): void
    {
        $months = [
            1  => 'يناير',
            2  => 'فبراير',
            3  => 'مارس',
            4  => 'ابريل',
            5  => 'مايو',
            6  => 'يونيو',
            7  => 'يوليو',
            8  => 'اغسطس',
            9  => 'سبتمبر',
            10 => 'اكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر',
        ];

        $years = Years::all();

        foreach ($years as $year) {
            foreach ($months as $number => $name) {
                Months::firstOrCreate(
                    [
                        'year_id'       => $year->id,
                        'month_number'  => $number,
                    ],
                    [
                        'month_name' => $name,
                    ]
                );
            }
        }

        $this->command->info('✅ تمت إضافة كل الشهور (بالترتيب الصحيح) لكل سنة.');
    }
}
