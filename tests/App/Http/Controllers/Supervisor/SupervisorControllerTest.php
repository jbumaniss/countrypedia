<?php

namespace Tests\App\Http\Controllers\Supervisor;

use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SupervisorControllerTest extends TestCase
{
    public function test_supervisor_action(): void
    {
        $user = User::factory()->create([
            'is_supervisor' => true,
        ]);
        $this->actingAs($user);

        $response = $this->post(route('supervisor.action'));

        $response->assertStatus(200);
        $this->assertEquals(
            '{"message":"Supervisor action executed successfully."}',
            $response->getContent()
        );
    }
}