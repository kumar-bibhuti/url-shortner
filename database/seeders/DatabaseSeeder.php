<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $company = Company::factory()->create(['name' => 'Test Company']);

        User::factory()->member()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'company_id' => $company->id,
        ]);
        $this->call(SuperAdminSeeder::class);
    }
}
