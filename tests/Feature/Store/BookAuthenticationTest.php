<?php

namespace Tests\Feature\Store;

use Tests\TestCase;

class BookAuthenticationTest extends TestCase
{
    public function test_requires_authentication(): void
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(401);
    }
}
