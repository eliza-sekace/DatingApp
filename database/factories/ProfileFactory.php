<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'description' => $this->faker->paragraph,
            'birthday' => $this->faker->dateTimeBetween($startDate = '-100 years', $endDate = '-18')->format("Y-m-d"),
            'gender' => collect(['Mr', 'Ms'])->random(),
            'interested_in' =>collect(['Mr', 'Ms', 'Everyone'])->random(),
            'location' => collect(['Riga', 'Bauska', 'Kekava', 'Jekabpils', 'Ventspils'])->random(),
            'age_from' => $this->faker->numberBetween(18, 40),
            'age_to' => $this->faker->numberBetween(41, 100)
        ];
    }
}
