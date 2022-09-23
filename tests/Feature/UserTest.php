<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_creating_a_new_user()
    {
        $user = [
            "first_name" => "Demetrius",
            "last_name" => "Lewis",
            "password" => "test1234",
            "password_confirmation" => "test1234",
            "email" => "client@test.com",
            "type" => "client",
            "is_admin" => false
        ];

        $this->postJson('/api/v1/auth/signup', $user)->assertStatus(201);

        // There is no password_confirmation field in database.
        unset($user['password_confirmation']);
        $this->assertDatabaseHas('users', $user);
    }
}
