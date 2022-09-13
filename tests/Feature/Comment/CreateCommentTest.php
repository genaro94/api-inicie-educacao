<?php

namespace Tests\Feature\Comment;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        ->post('/api/posts', [
           'user_id'  => $user['data']['id'],
           'title'    => fake()->text(),
           'body'     => fake()->text()
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments', [
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

    public function test_field_post_id_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments', [
            'post_id'  => null,
            'name'     => fake()->name(),
            'email'    => fake()->email(),
            'body'     => fake()->text()
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_field_email_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments', [
            'post_id'  => 1566,
            'name'     => fake()->name(),
            'email'    => null,
            'body'     => fake()->text()
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_field_email_is_valid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments', [
            'post_id'  => 1566,
            'name'     => fake()->name(),
            'email'    => "email.test",
            'body'     => fake()->text()
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_field_body_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments', [
            'post_id'  => 1566,
            'name'     => fake()->name(),
            'email'    => fake()->email(),
            'body'     => null
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'code'    => 422,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }

    public function test_create_comment_with_token_invalid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer 1234567890')
        ->post('/api/comments', [
            'post_id'  => 1566,
            'name'     => fake()->name(),
            'email'    => fake()->email(),
            'body'     => fake()->text()
        ]);

        $response->assertStatus(401)
        ->assertJson([
            'code'    => 401,
            'meta'    => null,
            'data'    => $response->original['data']
        ]);
    }
}
