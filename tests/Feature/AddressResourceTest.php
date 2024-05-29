<?php

namespace Tests\Feature;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AddressResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_addresses_show_resource(): void
    {
        $address = Address::factory()->create();
        $response = $this->get('/api/addresses/'. $address->id);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(
                [
                    'data.id',
                    'data.country',
                    'data.settlement',
                    'data.street',
                    'data.streetNumber',
                    'data',
                    'meta',
                    'meta.message'
                ]));
    }

}
