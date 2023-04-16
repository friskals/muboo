<?php

namespace Database\Factories;

use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $bookAuthor = BookAuthor::factory()->create();

        $user  = User::factory()->create();

        return [
            'book_id' => $bookAuthor->book_id,
            'type' => 'REVIEW',
            'content' => $this->faker->sentence(12),
            'user_id' => $user->id
        ];
    }
}
