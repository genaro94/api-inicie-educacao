<?php

namespace Tests\Feature\Post;

use Illuminate\Support\Arr;
use Tests\TestCase;

class UserPostListingTest extends TestCase
{
    private $token  = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status = ['active', 'inactive'];
    private $gender = ['female', 'male'];

    public function test_a_user_post_listing()
    {
        $user = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                         ->get('/api/users'.'/'.$user['data']['id'].'/posts');

        $response->assertStatus(200)
                 ->assertJson([
                    'code'  => 200,
                    'meta'  => [
                        'pagination'  => $response->original['meta']['pagination']
                    ],
                    'data'  => $response->original['data']
                 ]);
    }
}
