<?php

namespace Tests\App\Http\Controllers\Dashboard;

use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    public function test_index(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertInertia(function (AssertableInertia $page) use ($user) {
            $page->component('Dashboard')
                ->has('isSupervisor');
        });

    }
}