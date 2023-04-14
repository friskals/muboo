<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_successfully_add_content(){
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->signIn($user);

        $data = [
            'book_id' => $book->id,
            'type' => 'REVIEW',
            'content' => 'This is an incredible books which can reveal your personal doubt'
        ];

        $this->post('/api/content', $data)->assertStatus(200)
        ->assertJsonStructure(['content_id','success']);
    }
}
