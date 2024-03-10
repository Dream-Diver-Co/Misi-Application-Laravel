<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date_of_birth = $this->faker->dateTimeBetween('-70 years', '-18 years')->format('d-m-Y');
        $age = Carbon::parse($date_of_birth)->age;
        return [
            'name' => $this->faker->name(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'user_name' => $this->faker->unique()->regexify('[A-Za-z]{6}'),
            'phone' => $this->faker->phoneNumber(),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'date_of_birth' => $date_of_birth,
            // 'age' => $age,
            'user_serial_no' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'marital_status' => $this->faker->randomElement(['Married', 'Single', 'Divorced']),
            'profile_photo' => $this->faker->imageUrl(200, 200, 'people'),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
