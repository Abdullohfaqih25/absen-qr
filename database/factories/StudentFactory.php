<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(){
        return [
            'nis' => $this->faker->unique()->numerify('2025###'),
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];
    }
}
