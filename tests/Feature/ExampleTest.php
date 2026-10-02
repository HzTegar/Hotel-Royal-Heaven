<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // follow redirects so the test remains valid when '/' redirects to '/home'
        $response = $this->followingRedirects()->get('/');

        $response->assertStatus(200);
    }
}
