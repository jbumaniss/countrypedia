<?php

namespace Tests\App\Http\Controllers\Language;

use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    public function test_show(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('languages.show', ['id' => 1]));

        $response->assertStatus(200);
        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Language/Detail')
                ->has('language');
        });
    }
}