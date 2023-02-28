<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPost()
    {
        Session::start();

        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $this->call('POST', '/login', [
            'name' => $user->email,
            'password' => $password,
            '_token' => csrf_token()
        ])->assertRedirect('/');
    }
}
