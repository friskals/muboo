<?php

namespace Tests\Unit;

use App\Models\Category;
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
        $response = $this->post('/admin/categories',['name'=>'Science']);    

        $response->assertStatus(200);
    }

    public function test_show_category_success(){
        $category = Category::factory()->create();

        $response = $this->get('/admin/categories/' . $category->id);

        $category->delete();
        
        $response->assertStatus(200);
    }

    public function test_update_category_success(){

        $category = Category::factory()->create();

        $name_update = 'Science update';

        $response = $this->put('/admin/categories/'.$category->id, ['name'=> $name_update]);

        $category->refresh();

        $response->assertStatus(200);

        $this->assertEquals($name_update, $category->name);

        $category->delete();
    }

    public function test_delete_category_success(){
        $category = Category::factory()->create();

        $response = $this->delete('/admin/categories/' . $category->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories', ['id' => $category->id, 'name' => $category->name]);


    }
}