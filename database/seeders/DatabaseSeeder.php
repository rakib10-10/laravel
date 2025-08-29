<?php

namespace Database\Seeders;

use App\Models\User;
use App\MOdels\Patient;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

    Patient::factory(20)->create();
    User::factory(40)->create();


       
    }
}
