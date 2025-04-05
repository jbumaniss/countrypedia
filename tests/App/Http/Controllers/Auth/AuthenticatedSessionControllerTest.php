<?php

namespace Tests\App\Http\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;

class AuthenticatedSessionControllerTest extends TestCase
{
    public function test_authenticated_session_controller_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authenticated_session_controller_can_authenticate_user(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_session_controller_can_logout_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_authenticated_session_controller_can_render_login_view(): void
    {
        $response = $this->get('/login');

        $response->assertSee('Login');
        $response->assertSee('email');
        $response->assertSee('Password');
    }
}