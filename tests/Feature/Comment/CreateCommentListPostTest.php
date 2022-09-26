<?php

namespace Tests\Feature\Comment;

use Illuminate\Support\Arr;
use Tests\TestCase;

class CreateCommentListPostTest extends TestCase
{
    private $token         = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status        = ['active', 'inactive'];
    private $gender        = ['female', 'male'];

    public function test_create_comment_in_post_list_with_success(): void
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
        ->post('/api/comments/store/list/posts', [
           'post_id'  => $post['data']['id'],
           'name'     => fake()->name(),
           'email'    => fake()->unique()->email(),
           'body'     =>  fake()->text(),
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'code'    => 201,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_field_post_id_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments/store/list/posts', [
           'post_id'  => null,
           'name'     => fake()->name(),
           'email'    => fake()->unique()->email(),
           'body'     => fake()->text(),
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    "field"   => "post",
                    "message" => "must exist"
                ],
                [
                    "field"   => "post_id",
                    "message" => "is not a number"
                ]
            ]
        ]);
    }

    public function test_field_name_comment_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments/store/list/posts', [
           'post_id'  => 1441,
           'name'     => null,
           'email'    => fake()->unique()->email(),
           'body'     => fake()->text(),
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => [
                [
                    "field"   => "name",
                    "message" => "can't be blank"
                ],
            ]
        ]);
    }

    public function test_field_email_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments/store/list/posts', [
           'post_id'  => 1441,
           'name'     => fake()->name(),
           'email'    => null,
           'body'     => fake()->text(),
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

    public function test_field_token_is_valid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . '123456790')
        ->post('/api/comments/store/list/posts', [
           'post_id'  => 1441,
           'name'     => fake()->name(),
           'email'    => fake()->unique()->email(),
           'body'     => fake()->text(),
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
