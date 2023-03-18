<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

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
        $image = UploadedFile::fake()->image("{$this->faker->word()}.png", 10, 10);

        $image->storeAs('images', $image->name, 'public');

        $category = Category::factory()->create();

        return [
            'title' => $this->faker->words(3, true),
            'is_published' => 0,
            'image' => $image->storeAs('images', $image->name, 'public'),
            'category_id' => $category->id,
            'released_date' => now()->toDate()
        ];
    }
}
