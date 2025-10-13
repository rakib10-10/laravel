<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('medicines')->insert([
            ['name' => 'Paracetamol', 'dosage_form' => 'Tablet', 'strength' => '500 mg', 'manufacturer' => 'Square Pharmaceuticals Ltd.', 'description' => 'Used for pain relief and fever reduction.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa', 'dosage_form' => 'Tablet', 'strength' => '500 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Common analgesic and antipyretic.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Ace', 'dosage_form' => 'Tablet', 'strength' => '500 mg', 'manufacturer' => 'Renata Ltd.', 'description' => 'Pain and fever reducer.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Seclo', 'dosage_form' => 'Capsule', 'strength' => '20 mg', 'manufacturer' => 'Square Pharmaceuticals Ltd.', 'description' => 'Used for acid reflux and ulcers.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Losectil', 'dosage_form' => 'Capsule', 'strength' => '20 mg', 'manufacturer' => 'Eskayef Pharmaceuticals Ltd.', 'description' => 'Treats gastric and duodenal ulcers.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Amodis', 'dosage_form' => 'Tablet', 'strength' => '400 mg', 'manufacturer' => 'Incepta Pharmaceuticals Ltd.', 'description' => 'Used for diarrhea and dysentery.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Azithromycin', 'dosage_form' => 'Capsule', 'strength' => '500 mg', 'manufacturer' => 'Square Pharmaceuticals Ltd.', 'description' => 'Broad-spectrum antibiotic.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cef-3', 'dosage_form' => 'Capsule', 'strength' => '200 mg', 'manufacturer' => 'Square Pharmaceuticals Ltd.', 'description' => 'Cephalosporin antibiotic for infections.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Extend', 'dosage_form' => 'Tablet', 'strength' => '665 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Extended-release pain reliever.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Syrup', 'dosage_form' => 'Syrup', 'strength' => '120 mg/5ml', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Fever reducer for children.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Extra', 'dosage_form' => 'Tablet', 'strength' => '500 mg + 65 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Combines paracetamol and caffeine for headaches.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Rapid', 'dosage_form' => 'Tablet', 'strength' => '500 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Fast-acting paracetamol formula.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa IV', 'dosage_form' => 'Injection', 'strength' => '1000 mg/100ml', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'IV infusion for severe pain or fever.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Suppository', 'dosage_form' => 'Suppository', 'strength' => '125 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Used in fever management for children.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Drops', 'dosage_form' => 'Drops', 'strength' => '100 mg/ml', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'For infant fever relief.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Junior', 'dosage_form' => 'Tablet', 'strength' => '250 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Mild pain and fever reducer for kids.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Max', 'dosage_form' => 'Tablet', 'strength' => '1000 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'High-dose paracetamol for adults.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Softgel', 'dosage_form' => 'Capsule', 'strength' => '500 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Softgel for easy swallowing.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Cold', 'dosage_form' => 'Tablet', 'strength' => '500 mg + 5 mg + 2 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Relief from cold and fever.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Cold & Flu', 'dosage_form' => 'Tablet', 'strength' => '500 mg + 10 mg + 5 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'For flu-like symptoms and nasal congestion.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Extend XR', 'dosage_form' => 'Tablet', 'strength' => '665 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Long-acting paracetamol formulation.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Plus', 'dosage_form' => 'Tablet', 'strength' => '500 mg + 30 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Paracetamol with caffeine for extra relief.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Vita', 'dosage_form' => 'Tablet', 'strength' => '500 mg + Vitamins', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Pain relief with added vitamins.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Forte', 'dosage_form' => 'Tablet', 'strength' => '1000 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Extra strength paracetamol tablet.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Care', 'dosage_form' => 'Tablet', 'strength' => '500 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Regular painkiller.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Relief', 'dosage_form' => 'Tablet', 'strength' => '500 mg', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'For mild to moderate pain.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Gel', 'dosage_form' => 'Gel', 'strength' => '5%', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Topical pain relief gel.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa Cough Syrup', 'dosage_form' => 'Syrup', 'strength' => '100 ml', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Used to relieve cough and cold.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa DS', 'dosage_form' => 'Suspension', 'strength' => '250 mg/5ml', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Double-strength paracetamol suspension.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Napa IV Max', 'dosage_form' => 'Injection', 'strength' => '1000 mg/100ml', 'manufacturer' => 'Beximco Pharmaceuticals Ltd.', 'description' => 'Strong IV formulation for hospitals.', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
