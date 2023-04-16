<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Content;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentTest extends TestCase
{
    private const ENDPOINT ='content/';

    use RefreshDatabase;

    public function test_successfully_add_content()
    {
        $this->post(self::ENDPOINT, $this->setContent())->assertStatus(200)
            ->assertJsonStructure(['content_id', 'success']);
    }

    public function test_successfully_update_content()
    {
        $response = $this->post(self::ENDPOINT, $this->setContent())
            ->assertStatus(200)
            ->getContent();

        $response = json_decode($response);

        $new_data = [
            'content_id' => $response->content_id,
            'content' => 'udpate content'
        ];

        $this->put(self::ENDPOINT, $new_data)
            ->assertStatus(200)
            ->assertJsonStructure(['success']);

        $content = Content::find($response->content_id);

        $this->assertEquals($new_data['content'], $content->content);
    }

    private function setContent()
    {
        $book = Book::factory()->create();

        $user = User::factory()->create();

        $this->signIn($user);

        return [
            'book_id' => $book->id,
            'type' => 'REVIEW',
            'content' => 'This is an incredible books which can reveal your personal doubt'
        ];
    }

    public function test_successfully_delete_content()
    {
        $response = $this->post(self::ENDPOINT, $this->setContent())
            ->assertStatus(200)
            ->getContent();

        $response = json_decode($response);

        $this->delete(self::ENDPOINT, ['content_id' => $response->content_id])
            ->assertStatus(200)
            ->assertJsonStructure(['success']);
    }

    public function test_successfully_see_content()
    {
        $response = $this->post(self::ENDPOINT, $this->setContent())
            ->assertStatus(200)
            ->getContent();

        $response = json_decode($response);

        $this->get(self::ENDPOINT . $response->content_id)
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data']);
    }

    public function test_e2e_successfully()
    {
        /**
         * The E2E Flow
         * 1. Create content
         * 2. Update Content
         * 3. Get Content Detail
         * 4. Delete Content
         */

        $response = $this->post(self::ENDPOINT, $this->setContent())
            ->assertStatus(200)
            ->getContent();

        $response = json_decode($response);

        $new_data = [
            'content_id' => $response->content_id,
            'content' => 'udpate content'
        ];

        $this->put(self::ENDPOINT, $new_data)
            ->assertStatus(200)
            ->assertJsonStructure(['success']);

        $content = Content::find($response->content_id);

        $this->assertEquals($new_data['content'], $content->content);


        $this->get(self::ENDPOINT . $response->content_id)
            ->assertStatus(200)
            ->assertSee([$new_data['content'], $content->id]);

        $this->delete(self::ENDPOINT, ['content_id' => $response->content_id])
            ->assertStatus(200)
            ->assertJsonStructure(['success']);
    }
}
