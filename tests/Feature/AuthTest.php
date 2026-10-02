<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login_returns_api_token()
    {
        // register
        $registerData = [
            'username' => 'testuser',
            'email' => 'testuser@example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson('/api/register', $registerData)
            ->assertStatus(201)
            ->assertJsonStructure(['user', 'api_token']);

        // login
        $loginData = [
            'username' => 'testuser',
            'password' => 'password',
        ];

        $this->postJson('/api/login', $loginData)
            ->assertStatus(200)
            ->assertJsonStructure(['user', 'api_token']);
    }
}
