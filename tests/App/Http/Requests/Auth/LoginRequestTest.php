<?php

namespace Tests\App\Http\Requests\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    private LoginRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new LoginRequest();
    }

    public function test_it_is_authorized(): void
    {
        $request = $this->request;
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertTrue($request->authorize());
    }

    public function test_validation_rules(): void
    {
        $request = $this->request;
        $rules = $request->rules();

        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);
        $this->assertContains('required', $rules['email']);
        $this->assertContains('string', $rules['email']);
        $this->assertContains('email', $rules['email']);
        $this->assertContains('required', $rules['password']);
        $this->assertContains('string', $rules['password']);
    }

    public function test_authenticate_fails_with_invalid_credentials(): void
    {
        RateLimiter::clear('nonexistent@example.com|' . request()->ip());

        $request = $this->request;
        $request->merge([
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->expectException(ValidationException::class);
        $request->authenticate();
    }

    public function test_authenticate_passes_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'valid@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        RateLimiter::clear($user->email . '|' . request()->ip());

        $request = $this->request;
        $request->merge([
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->expectNotToPerformAssertions();
        $request->authenticate();

        RateLimiter::clear($request->throttleKey());
    }
}
