<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'last_names' => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'major_id' => Major::inRandomOrder()->first()->id,
            'status' => $this->faker->boolean(68),
        ];
    }
}
