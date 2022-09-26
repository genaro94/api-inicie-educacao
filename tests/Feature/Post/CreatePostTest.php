<?php

namespace Tests\Feature\Post;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    private $token  = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status = ['active', 'inactive'];
    private $gender = ['female', 'male'];

    public function test_create_post_with_success(): void
    {
        $user = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users'.'/'. $user['data']['id'] .'/posts', [
           'title'    => fake()->text(),
           'body'     => fake()->text()
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'code'    => 201,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_post_field_title_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users/123/posts', [
           'title'    => null,
           'body'     => fake()->text()
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    "field"   => "title",
                    "message" => "can't be blank"
                ]
            ]
        ]);
    }

    public function test_post_field_body_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users/123/posts', [
           'title'    => fake()->text(),
           'body'     => null
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    "field"   => "body",
                    "message" => "can't be blank"
                ]
            ]
        ]);
    }

    public function test_create_post_with_token_invalid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer 1234567890')
        ->post('/api/users/123/posts', [

            'title'    => fake()->text(),
            'body'     => fake()->text()
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
