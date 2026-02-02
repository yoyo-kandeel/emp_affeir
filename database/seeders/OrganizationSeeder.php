<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::create([
            'name' => 'الشركة المثال',
            'english_name' => 'Example Company',
            'tax_number' => '123456789',
            'commercial_register' => '987654321',
            'phone' => '+201234567890',
            'email' => 'info@example.com',
            'website' => 'https://example.com',
            'address' => 'القاهرة، مصر',
            'description' => 'هذه شركة نموذجية للتوضيح.',
            'logo' => 'logos/example_logo.png', // ضع الملف في storage/app/public/logos
            'created_by' => 'admin',
        ]);
    }
}
