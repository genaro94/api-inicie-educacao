<?php

namespace Tests\Feature\Comment;

use Illuminate\Support\Arr;
use Tests\TestCase;

class CreateCommentTest extends TestCase
{
    private $token  = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status = ['active', 'inactive'];
    private $gender = ['female', 'male'];

    public function test_create_comment_with_success(): void
    {
        $user = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $post = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users'.'/'. $user['data']['id'] .'/posts', [
           'title'    => fake()->text(),
           'body'     => fake()->text()
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/posts'.'/'.$post['data']['id'].'/comments', [
           'post_id'  => $post['data']['id'],
           'name'     => fake()->name(),
           'email'    => fake()->email(),
           'body'     => fake()->text()
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'code'    => 201,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_field_name_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/posts/123/comments', [
            'name'     => null,
            'email'    => fake()->name(),
            'body'     => fake()->text()
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    "field"   => "name",
                    "message" => "can't be blank"
                ]
            ]
        ]);
    }

    public function test_field_email_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/posts/123/comments', [
            'name'     => fake()->name(),
            'email'    => null,
            'body'     => fake()->text()
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    "field"   => "email",
                    "message" => "can't be blank, is invalid"
                ]
            ]
        ]);
    }

    public function test_field_email_format_is_valid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/posts/123/comments', [
            'name'     => fake()->name(),
            'email'    => "email.test",
            'body'     => fake()->text()
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    "field"    => "email",
                    "message"  => "is invalid"
                ]
            ]
        ]);
    }

    public function test_field_body_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/posts/123/comments', [
            'name'     => fake()->name(),
            'email'    => fake()->email(),
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

    public function test_create_comment_with_token_invalid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer 1234567890')
        ->post('/api/posts/123/comments', [
            'name'     => fake()->name(),
            'email'    => fake()->email(),
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
