<?php

namespace Tests\Feature\Comment;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CreateCommentListPostTest extends TestCase
{
    private $token         = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status        = ['active', 'inactive'];
    private $gender        = ['female', 'male'];
    private $commentStatus = ['completed', 'pending'];

    public function test_create_comment_in_post_list_with_success(): void
    {
        $user = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments/store/list/posts', [
           'user_id'  => $user['user']['id'],
           'title'    => fake()->text(),
           'due_on'   => \Carbon\Carbon::today(),
           'status'   => Arr::random($this->commentStatus),
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'message' => 'Comment created successfully!',
            'comment' => $response->original['comment']
        ]);
    }

    public function test_field_user_id_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments/store/list/posts', [
           'user_id'  => null,
           'title'    => fake()->text(),
           'due_on'   => \Carbon\Carbon::today(),
           'status'   => Arr::random($this->commentStatus),
        ]);

        $response->assertStatus(401)
        ->assertJson([
            'message' => 'user must exist'
        ]);
    }

    public function test_field_title_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments/store/list/posts', [
           'user_id'  => 2752,
           'title'    => null,
           'due_on'   => \Carbon\Carbon::today(),
           'status'   => Arr::random($this->commentStatus),
        ]);

        $response->assertStatus(401)
        ->assertJson([
            'message' => "title can't be blank"
        ]);
    }

    public function test_field_status_is_required(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/comments/store/list/posts', [
           'user_id'  => 2752,
           'title'    => fake()->text(),
           'due_on'   => \Carbon\Carbon::today(),
           'status'   => null,
        ]);

        $response->assertStatus(401)
        ->assertJson([
            'message' => "status can't be blank, can be pending or completed"
        ]);
    }
}
