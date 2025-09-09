<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        // Fake medicines array
        $medicines = [
            [
                'name' => $this->faker->randomElement(['Paracetamol', 'Ibuprofen', 'Amoxicillin', 'Ciprofloxacin']),
                'dosage' => $this->faker->randomElement(['1x Daily', '2x Daily', 'Every 6 hours']),
                'note' => $this->faker->sentence(3)
            ],
            [
                'name' => $this->faker->randomElement(['Vitamin D', 'Azithromycin', 'Cough Syrup']),
                'dosage' => $this->faker->randomElement(['Once a day', 'Twice a day']),
                'note' => $this->faker->sentence(2)
            ]
        ];

        // Fake tests array
        $tests = $this->faker->randomElements(
            ['Blood Test', 'X-Ray', 'MRI Scan', 'Urine Test', 'CT Scan'],
            $this->faker->numberBetween(1, 3)
        );

        return [
            'patient_id' => Patient::factory(),   // generates a fake patient
            'doctor_id' => Doctor::factory(),     // generates a fake doctor
            'visit_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'diagnosis' => $this->faker->sentence(8),
            'medicines' => json_encode($medicines),
            'tests' => json_encode($tests),
            'additional_notes' => $this->faker->paragraph(),
        ];
    }
}
