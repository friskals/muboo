<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $author = Author::factory()->create();
        $image = UploadedFile::fake()->image("{$this->faker->word()}.png", 10, 10);

        $image->storeAs('images', $image->name, 'public');

        return [
            'author_id' => $author->id,
            'author_name' => $author->name,
            'title' => $this->faker->words(3, true),
            'is_published' => 0,
            'image' => $image->storeAs('images', $image->name, 'public')

        ];
    }
}
