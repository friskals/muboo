<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookAuthor>
 */
class BookAuthorFactory extends Factory
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

        $author = Author::factory()->create();
        
        $book = Book::factory()->create([
            'title' => $this->faker->words(3, true),
            'image' => $image->storeAs('images', $image->name, 'public'),
            'category_id' => $category->id,
            'released_date' => now()->toDate(),
            'is_published'=> 0
        ]);

        return [
            'book_id' => $book->id,
            'book_title' => $book->title,
            'author_id' => $author->id,
            'author_name' => $author->name,
            'is_published' => $book->is_published,
            'image' => $book->image            
        ];
    }
}
