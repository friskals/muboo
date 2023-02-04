<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/admin/books';

    public function test_store_book_success(){
        
        $author =  Author::factory()->create();

        Storage::fake('images');

        $image = UploadedFile::fake()->image('cover.png', 10, 10);

        $request = [
            'title' => 'book title',
            'author_id' => $author->id,
            'author_name' => $author->name,
            'image' => $image,
            'is_published' => 1
        ];

        $response = $this->post(SELF::ENDPOINT, $request);

        $response->assertStatus(200);

        Storage::disk('public')->assertExists('images/cover.png');

        $this->assertDatabaseHas('books',['title'=>$request['title'],'author_id'=> $request['author_id']]);
    }
}
