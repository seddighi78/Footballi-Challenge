<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private const VALID_USERNAME = 'seddighi78';
    private const INVALID_USERNAME = 'this_is_the_invalid_username_$_#_never_use_it';

    public function test_login_with_valid_input_is_success(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $data = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'access_token',
            ]
        ]);
    }

    public function test_login_with_invalid_input_should_throw_validation_errors(): void
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['username', 'password'], 'data.validation_errors');
    }

    public function test_login_with_wrong_input_should_throw_403(): void
    {
        $data = [
            'username' => $this->faker->userName,
            'password' => 'password_is_wrong',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertForbidden();
    }

    public function test_register_with_valid_input_is_success(): void
    {
        $data = [
            'name' => $this->faker->name,
            'username' => self::VALID_USERNAME,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/auth/register', $data);

        $response->assertOk();
        $response->assertJsonFragment(['code' => 200]);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
            ]
        ]);
    }

    public function test_register_with_invalid_input_should_throw_validation_errors(): void
    {
        $data = [
            'name' => null,
            'username' => self::INVALID_USERNAME,
            'password' => '1234',
        ];

        $response = $this->postJson('/api/auth/register', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'username', 'password'], 'data.validation_errors');
    }
}
