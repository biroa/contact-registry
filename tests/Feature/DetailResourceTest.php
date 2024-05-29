<?php

namespace Tests\Feature;

use App\Models\Detail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DetailResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test address show response
     */
    public function test_details_show_resource(): void
    {
        $detail = Detail::factory()->create();
        $response = $this->get('/api/details/'.$detail->id);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(
                [
                    'data.key',
                    'data.value',
                ]));
    }

    /**
     * Test delete a contact resource.
     *
     * @return void
     */
    public function test_soft_delete_resource()
    {
        $contact = Detail::factory()->create();

        $response = $this->delete('/api/details/'.$contact->id);

        // Assert that the request was successful (status code 204)
        $response->assertStatus(200);
        $this->assertSoftDeleted(Detail::class);
    }

}
