<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_category_success()
    {
        $this->signIn();
        
        $this->get('/admin/categories/create')->assertStatus(200);

        $this->followingRedirects()->post('/admin/categories', ['name' => 'Science','status'=>'Inactive'])
        ->assertSee('Science');
    }

    public function test_show_category_success()
    {
        $this->signIn();

        $category = Category::factory()->create();

        $response = $this->get('/admin/categories/' . $category->id);

        $category->delete();

        $response->assertStatus(200);
    }

    public function test_update_category_success()
    {
        $this->signIn();

        $category = Category::factory()->create();

        $name_update = 'Science update';

        $this->put('/admin/categories/' . $category->id, ['name' => $name_update,'status'=>'Active'])
        ->assertRedirect(route('categories.index'));

        $category->refresh(); 

        $this->assertEquals($name_update, $category->name);

        $category->delete();
    }

    public function test_delete_category_success()
    {
        $this->signIn();

        $category = Category::create(['name'=>'lorem ipsum','status'=>'Inactive']);

        $this->delete('/admin/categories/' . $category->id)
        ->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id, 'name' => $category->name]);
    }

    public function test_unauthorized_cannot_create_project()
    {
        $this->withoutExceptionHandling();

        $user =  new User();
        $user->name = 'unauthorize_user';
        $user->id = 1;
        $user->email = "user@testing.com";

        $response = $this->be($user)->post('/admin/categories', ['name' => 'Science']);

        $response->assertRedirect('/unauthorized');//>assertStatus(401);

    }
}
