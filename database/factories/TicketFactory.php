<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $totalPatients = Patient::count();
        return [
            'department_id' => $this->faker->numberBetween(4, 10),
            'patient_id' => $this->faker->numberBetween(1, $totalPatients),
            // 'assigned_staff' => $this->faker->randomNumber(),
            // 'assigned_therapist' => $this->faker->randomNumber(),
            // 'suggested_therapists' => $this->faker->word,
            'mono_multi_zd' => $this->faker->word,
            'mono_multi_screening' => $this->faker->word,
            'intake_or_therapist' => $this->faker->word,
            'tresonit_number' => $this->faker->word,
            'datum_intake' => $this->faker->word,
            'datum_intake_2' => $this->faker->word,
            'nd_account' => $this->faker->word,
            'avc_alfmvm_sbg' => $this->faker->word,
            'honos' => $this->faker->word,
            'berha_intake' => $this->faker->word,
            // 'strike_history' => $this->faker->word,
            // 'ticket_history' => $this->faker->word,
            'rom_start' => $this->faker->date(),
            'rom_end' => $this->faker->date(),
            'berha_end' => $this->faker->date(),
            'vtcb_date' => $this->faker->date(),
            'closure' => $this->faker->date(),
            'aanm_intake_1' => $this->faker->date(),
            'location' => $this->faker->word,
            'call_strike' => $this->faker->word,
            'remarks' => $this->faker->word,
            'status' => 'open',
            'comment' => $this->faker->word,
            'language' => $this->faker->word,
            // 'status' => $this->faker->word,
        ];
    }
}
