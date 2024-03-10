<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $totalUsers = User::count();
        return [
            'user_id' => $this->faker->unique()->numberBetween(1, $totalUsers),
            'patient_source' => $this->faker->word,
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'country' => $this->faker->country,
            'residential_address' => $this->faker->address,
            'insurance_number' => $this->faker->numerify('##########'),
            'occupation' => $this->faker->jobTitle,
            // 'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'alternative_phone' => $this->faker->phoneNumber,
            'emergency_contact' => $this->faker->name,
            'remarks' => $this->faker->sentence,
            'city_or_state' => $this->faker->city,
            'area' => $this->faker->streetName,
            'DOB_number' => $this->faker->numerify('##########'),
            'BSN_number' => $this->faker->numerify('##########'),
            'file_type' => $this->faker->fileExtension,
            'file' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
