<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
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
            'name' => $this->faker->unique()->company(),
            'slug' => Str::snake(strtolower($this->faker->unique()->company())),
            'description' => $this->faker->unique()->paragraph(rand(3, 5)),
            'telephone' => phoneNumberPrefix($this->faker->unique()->phoneNumber()),
            'email' => $this->faker->unique()->email(),
            'logo' => $this->faker->unique()->imageUrl(),
            'website' => $this->faker->unique()->url(),
            'subscribed_at' => now()->toDateTimeString(),
            // 'unsubscribed_at' => 'nullable|timestamp'
        ];
    }
}
