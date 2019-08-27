<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tasks
        factory(User::class, 10)->create();
    }
}
