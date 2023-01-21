<?php

namespace Tests\Unit;

use Tests\TestCase;

class CategoryTest extends TestCase
{
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
}
