<?php

namespace Tests\App\Http\Controllers\Country;

use App\Models\User;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->get(route('countries.index'));

        $originalContent = $response->getOriginalContent();

        $response->assertStatus(200);
        $this->assertEquals('Country/Index', $originalContent->getData()['page']['component']);
        $response->assertSee('countries');
    }

    public function test_show(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('countries.show', ['id' => 1]));

        $response->assertStatus(200);
        $this->assertEquals('Country/Detail', $response->getOriginalContent()
            ->getData()['page']['component']);
        $response->assertSee('country');
    }
}