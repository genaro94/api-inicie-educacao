<?php

namespace Tests\Feature\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ListingUserTest extends TestCase
{
    private $token  = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';
    private $status = ['active', 'inactive'];
    private $gender = ['female', 'male'];

    public function test_user_listing_all(): void
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200)
        ->assertJson([
            'code'  => 200,
            'meta'  => [
                'pagination'  => $response->original['meta']['pagination']
            ],
            'data'  => $response->original['data']
        ]);
    }

    public function test_user_listing_with_pagination(): void
    {
        $response = $this->get('/api/users?page=2');

        $response->assertStatus(200)
        ->assertJson([
            'code'  => 200,
            'meta'  => [
                'pagination'  => $response->original['meta']['pagination']
            ],
            'data'  => $response->original['data']
        ]);
    }

    public function test_user_listing_with_filter_by_id(): void
    {
        $user = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->post('/api/users', [
            'name'   => fake()->name(),
            'email'  => fake()->unique()->email(),
            'gender' => Arr::random($this->gender),
            'status' => Arr::random($this->status),
        ]);

        $response = $this->get('/api/users/'. $user['data']['id']);

        $response->assertStatus(200)
        ->assertJson([
            'code'  => 200,
            'meta'  => null,
            'data'  => $response->original['data']
        ]);
    }
}
