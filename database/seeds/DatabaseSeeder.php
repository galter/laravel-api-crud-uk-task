<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::firstOrCreate(
            ['email' => 'bilbo@baggins.uk'],
            [
                'givenName' => 'Bilbo',
                'familyName' => 'Baggins',
                'password' => '_my_pr3c10u5_'
            ]
        );
    }
}
