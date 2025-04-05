<?php

namespace Tests\App\Http\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;

class EmailVerificationNotificationControllerTest extends TestCase
{
    public function test_email_verification_notification(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect();
    }

    public function test_email_verification_notification_already_verified(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('dashboard.index', absolute: false));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}