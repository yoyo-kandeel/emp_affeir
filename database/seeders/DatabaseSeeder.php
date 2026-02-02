<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
                RolePermissionUserSeeder::class,
                DepartmentSeeder::class,
                JobSeeder::class,
                EmpDataSeeder::class,
                EmploymentDataSeeder::class,
                YearsSeeder::class,
                MonthsSeeder::class,
                OrganizationSeeder::class,

        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
