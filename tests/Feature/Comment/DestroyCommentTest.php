<?php

namespace Tests\Feature\Comment;

use Illuminate\Support\Arr;
use Tests\TestCase;

class DestroyCommentTest extends TestCase
{
    private $token  = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status = ['active', 'inactive'];
    private $gender = ['female', 'male'];

    public function test_destroy_comment_with_success(): void
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

        $comment = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments', [
           'post_id'  => $post['data']['id'],
           'name'     => fake()->name(),
           'email'    => fake()->email(),
           'body'     => fake()->text()
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                         ->delete('/api/comments'.'/'. $comment['data']['id']);

        $response->assertStatus(204);
    }

    public function test_destroy_comment_does_not_exist(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->delete('/api/comments/120000000000000');

        $response->assertStatus(404)
        ->assertJson([
            'code'    => 404,
            'meta'    => null,
            'data'    => [
                'message' => 'Resource not found'
            ]
        ]);
    }

    public function test_destroy_comment_with_token_invalid(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer 1234567890' )
        ->delete('/api/comments/123');

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
