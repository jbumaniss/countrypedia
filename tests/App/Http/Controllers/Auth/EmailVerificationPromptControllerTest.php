<?php

namespace Tests\App\Http\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;

class EmailVerificationPromptControllerTest extends TestCase
{
    public function test_email_verification_prompt_redirects_verified_user(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertRedirect(route('dashboard.index', absolute: false));
    }

    public function test_email_verification_prompt_shows_unverified_user(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $response = $this->actingAs($user)
            ->get(route('verification.notice'));

        $response->assertOk();
        $originalContent = $response->getOriginalContent();
        $this->assertEquals('Auth/VerifyEmail', $originalContent->getData()['page']['component']);
    }
}