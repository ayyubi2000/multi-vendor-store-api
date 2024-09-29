<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'uz' => $this->faker->word(), // Uzbek translation
                'ru' => $this->faker->word(), // Russian translation
                'en' => $this->faker->word(), // English translation
            ],
            'slug' => $this->faker->slug(),
            'icon' => $this->faker->imageUrl(100, 100, 'cats'), // Example image URL for icon
            'image' => $this->faker->imageUrl(800, 600, 'cats'), // Example image URL for image
            'coefficient' => $this->faker->numberBetween(1, 10), // Random coefficient between 1 and 10
            'is_active' => $this->faker->boolean(), // Random boolean value for active status
            'sort' => $this->faker->numberBetween(1, 100), // Random sort value between 1 and 100
        ];
    }
}
