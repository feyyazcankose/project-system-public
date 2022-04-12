<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Teacher::class;

    public function definition()
    {
        return [
            'name'=> $this->faker->name,
            'email'=> $this->faker->email,
            'role_id'=> 2,
            'sicil'=> $this->faker->numberBetween($min = 1000, $max = 9999),
            'appellation' =>$this->faker->text($maxNbChars = 20),
            'password'=>Hash::make("kou1234"),
        ];
    }
}
