<?php

namespace Tests\Feature\User;

use Tests\TestCase;

class ListingUserTest extends TestCase
{
    private $token  = '7ba03f2c0a0909bd7c37efaadaa54777c2d0ff1d190878475c8fa953c3399609';

    public function test_user_listing_all(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->get('/api/users');

        $response->assertStatus(200);
    }
}
