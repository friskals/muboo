<?php

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    private const ENDPOINT = '/admin/authors';

    public function test_list_author_success()
    {
        $response = $this->get(self::ENDPOINT);    

        $response->assertStatus(200);
    }

    public function test_create_author_success()
    {
        $response = $this->post(self::ENDPOINT,['name'=>'Friska L']);    

        $response->assertStatus(200);

        //TODO
        //delete inserted author to takeout dummy data
    }
}
