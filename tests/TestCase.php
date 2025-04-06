<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function loginAndSignIn(array $parameters = []): User
    {
        $user = User::factory()->create($parameters);
        $this->actingAs($user);
        return $user;
    }
}
