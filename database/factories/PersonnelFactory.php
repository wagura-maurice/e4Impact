<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            '_pid' => Str::random(10),
            'category_id' => rand(1, 2),
            'title' => $this->faker->title(),
            'first_name' => $this->faker->unique()->firstName(),
            'middle_name' => $this->faker->unique()->name(),
            'last_name' => $this->faker->unique()->lastName(),
            'telephone' => phoneNumberPrefix($this->faker->unique()->phoneNumber()),
            'email' => $this->faker->unique()->email(),
            'website' => $this->faker->unique()->url(),
            'gender' => rand(1, 2),
            'address_line_1' => $this->faker->unique()->streetName(),
            'address_line_2' => $this->faker->unique()->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->citySuffix(),
            'country' => $this->faker->country(),
            'subscribed_at' => now()->toDateTimeString(),
            // 'unsubscribed_at' => 'nullable|timestamp'
        ];
    }
}
