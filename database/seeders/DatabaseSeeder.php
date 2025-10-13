<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Report;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

    Patient::factory(30)->create();
    User::factory(20)->create();
    Doctor::factory(15)->create();
    Report::factory(20)->create();

    $this->call(MedicineSeeder::class);

       
    }
}
