<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'user_id' => User::factory(),
        'name' => $this->faker->name,
        'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
        'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
        'blood_type' => $this->faker->randomElement(['A+','A-','B+','B-','AB+','AB-','O+','O-']),
        'address' => $this->faker->address,
        'emergency_contact' => $this->faker->phoneNumber,
];

    }
}
