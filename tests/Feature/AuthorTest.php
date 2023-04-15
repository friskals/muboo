<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/admin/authors';

    public function test_list_author_success()
    {
        $this->signIn();

        $author = Author::factory()->create();

       $this->get(self::ENDPOINT)->assertSee($author->name);
    }

    public function test_create_author_success()
    {
        $this->signIn();

        $this->post(self::ENDPOINT, ['name' => 'Friska L']);

        $this->followingRedirects()->post(self::ENDPOINT, ['name' => 'Friska L'])
            ->assertSee('Friska L');
    }

    public function test_show_author_success()
    {
        $this->signIn();

        $author = Author::factory()->create();

        $response = $this->get(self::ENDPOINT . '/' . $author->id);

        $response->assertStatus(200);
    }

    public function test_update_author_success()
    {
        $this->signIn();

        $author = Author::factory()->create();

        $this->get(self::ENDPOINT . "/{$author->id}/edit")->assertStatus(200);

        $new_name = 'Friska update';

        $this->followingRedirects()->put(self::ENDPOINT . '/' . $author->id, ['name' => $new_name])
            ->assertSee($new_name)
            ->assertStatus(200);

        $author->refresh();

        $this->assertEquals($new_name, $author->name);
    }

    public function test_delete_author_true()
    {
        $this->signIn();

        $author = Author::factory()->create();

        $this->followingRedirects()->delete(self::ENDPOINT . '/' . $author->id)
            ->assertDontSee($author->name);

        $this->assertDatabaseMissing('authors', [
            'id' => $author->id,
            'name' => $author->name
        ]);
    }
}
