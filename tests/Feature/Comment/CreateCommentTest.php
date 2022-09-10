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
           'user_id'  => $user['user']['id'],
           'title'    => fake()->text(),
           'body'     => fake()->text()
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments', [
           'post_id'  => $post['post']['id'],
           'name'     => fake()->name(),
           'email'    => fake()->email(),
           'body'     => fake()->text()
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'message' => 'Comment created successfully!',
            'comment' => $response->original['comment']
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

        $response->assertStatus(401)
        ->assertJson(['message' => "post must exist"]);
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

        $response->assertStatus(401)
        ->assertJson(['message' => "email can't be blank, is invalid"]);
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

        $response->assertStatus(401)
        ->assertJson(['message' => "email is invalid"]);
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

        $response->assertStatus(401)
        ->assertJson(['message' => "body can't be blank"]);
    }
}
