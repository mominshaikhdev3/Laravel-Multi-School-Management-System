<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a demo school (tenant) first, then attach a test user to it.
        $tenant = Tenant::create([
            'school_name' => 'Demo School',
            'address'     => '123 Main Street',
        ]);

        User::factory()->create([
            'name'      => 'Test User',
            'email'     => 'test@example.com',
            'tenant_id' => $tenant->tenant_id,
        ]);
    }
}
