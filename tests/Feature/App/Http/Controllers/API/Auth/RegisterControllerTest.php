<?php

namespace Tests\Feature\App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $register_route;

    protected function setUp(): void
    {
        parent::setUp();
        $this->register_route = '/api/v1/auth/signup';
        $this->data = [
            'email' => 'Test1@test.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'type' => 'client',
            'isAdmin' => false
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_can_sign_up()
    {
        $this->post($this->register_route, $this->data)
            ->assertStatus(201);

        $this->assertTrue(Hash::check($this->data['password'], User::whereEmail($this->data['email'])->first()->password));

        // remove password fields before testing database due to hashing.
        unset($this->data['password']);
        unset($this->data['password_confirmation']);
        $this->assertDatabaseHas(User::class, $this->data);
    }

    public function test_user_can_not_sign_up_without_email()
    {
        unset($this->data['email']);

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The email field is required.",
                "errors" => [
                    "email" => [
                        "The email field is required."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_without_password()
    {
        unset($this->data['password']);

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The password field is required.",
                "errors" => [
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_without_confirmed_password()
    {
        unset($this->data['password_confirmation']);

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The password confirmation does not match.",
                "errors" => [
                    "password" => [
                        "The password confirmation does not match."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_without_first_name()
    {
        unset($this->data['firstName']);

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The first name field is required.",
                "errors" => [
                    "firstName" => [
                        "The first name field is required."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_without_last_name()
    {
        unset($this->data['lastName']);

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The last name field is required.",
                "errors" => [
                    "lastName" => [
                        "The last name field is required."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_without_type()
    {
        unset($this->data['type']);

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The type field is required.",
                "errors" => [
                    "type" => [
                        "The type field is required."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_if_type_field_is_not_client_or_staff()
    {
        $this->data['type'] = 'false type';

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The selected type is invalid.",
                "errors" => [
                    "type" => [
                        "The selected type is invalid."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_without_isAdmin()
    {
        unset($this->data['isAdmin']);

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The is admin field is required.",
                "errors" => [
                    "isAdmin" => [
                        "The is admin field is required."
                    ]
                ]
            ]
        );
    }

    public function test_user_can_not_sign_up_if_isAdmin_field_is_not_a_boolean()
    {
        $this->data['isAdmin'] = 'not a boolean';

        $this->postJson($this->register_route, $this->data)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The is admin field must be true or false.",
                "errors" => [
                    "isAdmin" => [
                        "The is admin field must be true or false."
                    ]
                ]
            ]
        );
    }
}
