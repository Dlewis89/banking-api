<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_creating_a_new_client_user()
    {
        $response = $this->postJson('/api/v1/auth/signup', [
            "first_name" => "Demetrius",
            "last_name" => "Lewis",
            "password" => "test1234",
            "password_confirmation" => "test1234",
            "email" => "client@test.com",
            "type" => "client",
            "is_admin" => false
        ]);

        $response->assertStatus(201);
    }
}
