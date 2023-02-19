<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends  TestCase
{
    use RefreshDatabase;
    // use Exc
    public function test_register_user_success()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->post('/register',[
            'name'=>'friskals',
            'email' => "friskasianturi23@gmail.com",
            'password' => 'Apapap123**',
            'password_confirmation' => 'Apapap123**'
        ]);    

        $response->assertStatus(200);
    }
}
