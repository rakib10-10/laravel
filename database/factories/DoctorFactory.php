<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition()    
    {
        return [
            'user_id' => User::factory(),
            'doctor_id' => 'DOC' . str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'name' => $this->faker->name,
            'contact' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'country' => $this->faker->country,
            'date_of_birth' => $this->faker->dateTimeBetween('-65 years', '-28 years')->format('Y-m-d'),
            'blood_group' => $this->faker->randomElement(['A+','A-','B+','B-','AB+','AB-','O+','O-']),
            'specialization' => $this->faker->randomElement([
                'Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Dermatology', 'Oncology', 'Radiology'
            ]),
            'designation' => $this->faker->randomElement([
                'Consultant', 'Senior Consultant', 'Associate Professor', 'Professor', 'Medical Officer'
            ]),
            'department' => $this->faker->randomElement([
                'Medicine', 'Surgery', 'Gynecology', 'Emergency', 'ICU', 'Pathology'
            ]),
            'license_number' => strtoupper($this->faker->bothify('LIC#######')),
            'date_of_joining' => $this->faker->dateTimeBetween('-20 years', 'now')->format('Y-m-d'),
            'work_experience' => $this->faker->numberBetween(1, 35),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}