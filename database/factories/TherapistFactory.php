<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TherapistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $totalUsers = User::count();
        $patientUsers = Patient::all();
        $userIds = [];
        $existingUserIds = [];
        foreach ($patientUsers as $patient) {
            $existingUserIds[] = $patient->user_id;
        }
        while (count($userIds) < $totalUsers) {
            $userId = $this->faker->numberBetween(1, $totalUsers);

            if (!in_array($userId, $existingUserIds)) {
                $userIds[] = $userId;
            }
        }
        return [
            'user_id' => $this->faker->unique()->randomElement($userIds),
            'therapist_type' => $this->faker->word,
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'country' => $this->faker->country,
            'residential_address' => $this->faker->address,
            'insurance_number' => $this->faker->numerify('##########'),
            // 'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'alternative_phone' => $this->faker->phoneNumber,
            'emergency_contact' => $this->faker->name,
            'remarks' => $this->faker->sentence,
            'city_or_state' => $this->faker->city,
            'area' => $this->faker->streetName,
            'DOB_number' => $this->faker->numerify('##########'),
            'BSN_number' => $this->faker->numerify('##########'),
            'file' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
