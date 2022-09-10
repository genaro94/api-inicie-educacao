<?php

namespace Tests\Feature\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    private $token  = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status = ['active', 'inactive'];
    private $gender = ['female', 'male'];

    public function test_create_user_with_success(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'code'    => 201,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_field_name_user_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => null,
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    'field'    => 'name',
                    'message'  => "can't be blank"
                ]
            ]
        ]);
    }

    public function test_field_email_user_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => null,
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    'field'    => 'email',
                    'message'  => "can't be blank"
                ]
            ]
        ]);
    }

    public function test_field_email_user_is_unique(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => 'email@test.com',
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => 'email@test.com',
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    'field'    => 'email',
                    'message'  => "has already been taken"
                ]
            ]
        ]);
    }

    public function test_field_gender_user_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => null,
            'status' => Arr::random($this->status),
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    'field'    => 'gender',
                    'message'  => "can't be blank, can be male or female"
                ]
            ]
        ]);
    }

    public function test_field_gender_filled_in_without_male_or_female(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => "abcd",
            'status' => Arr::random($this->status),
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    'field'    => 'gender',
                    'message'  => "can't be blank, can be male or female"
                ]
            ]
        ]);
    }

    public function test_field_status_user_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => null,
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    'field'    => 'status',
                    'message'  => "can't be blank"
                ]
            ]
        ]);
    }

    public function test_field_status_filled_in_without_active_or_inactive(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => "abcd",
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    'field'    => 'status',
                    'message'  => "can't be blank"
                ]
            ]
        ]);
    }

    public function test_create_user_with_token_invalid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer 1234567890')
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response->assertStatus(401)
        ->assertJson([
            'code'    => 401,
            'meta'    => null,
            'data'    => [
                'message'  => "Authentication failed"
            ]
        ]);
    }

}
