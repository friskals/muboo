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

    public function test_show_author_success(){
        $author = Author::factory()->create();

        $response = $this->get(self::ENDPOINT .'/'. $author->id);

        $author->delete();
        
        $response->assertStatus(200);
    }

    public function test_update_author_success(){
        $author = Author::factory()->create();

        $new_name = 'Friska update';

        $response = $this->put(self::ENDPOINT . '/' . $author->id, ['name'=>$new_name]);
        
        $response->assertStatus(200);

        $author->refresh();


        $this->assertEquals($new_name, $author->name);
        
        $author->delete();
    }
   
}
