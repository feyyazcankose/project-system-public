<?php

namespace Database\Factories;

use App\Models\PeriodStudent;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model= Student::class;

    public function definition()
    {
        return [
            'name'=> $this->faker->name,
            'email'=> $this->faker->email,
            'role_id'=> 3,
            'student_number'=> $this->faker->numberBetween($min = 100000000, $max = 999999999),
            'tc'=> $this->faker->numberBetween($min = 100000000, $max = 999999999),
            'birth'=> $this->faker->dateTime($max = 'now', $timezone = null),
            'departman' =>$this->faker->text($maxNbChars = 20),
            'faculty'=>$this->faker->text($maxNbChars = 20),
            'university'=>$this->faker->text($maxNbChars = 20),
            'phone_number'=>$this->faker->phoneNumber,
            'password'=>Hash::make("kou1234"),
        ];

       

    }
}
