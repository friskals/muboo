<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends  TestCase
{
    use RefreshDatabase;

    public function test_register_user_success()
    {
        $this->withoutExceptionHandling();

        $this->post('/register', [
            'name' => 'friskals',
            'email' => "friskasianturi23@gmail.com",
            'password' => 'Apapap123**',
            'password_confirmation' => 'Apapap123**'
        ])
            ->assertRedirect('/dashboard');
    }
}
