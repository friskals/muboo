<?php

namespace Database\Factories;

use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use PhpParser\Node\Expr\Cast\String_;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookMusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();

        $bookAuthor = BookAuthor::factory()->create();
        
        return [
            'book_id' => $bookAuthor->book_id,
            'external_music_id' => $this->faker->word(),
            'title' => $this->faker->sentence(3),
            'fans' => 2//dummy data for number of user who add this book
        ];
    }
}
