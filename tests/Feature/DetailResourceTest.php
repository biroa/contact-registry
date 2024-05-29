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
     * Test address index response
     */
    public function test_details_index_page(): void
    {
        $details = Detail::factory(5)->create();
        $response = $this->get('/api/details/');
        $response->assertStatus(200)
            ->assertJsonCount($details->count(), 'data');
    }

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
                    'data',
                    'meta',
                    'meta.message',
                ]));
    }

    /**
     * Test updating a contact resource.
     */
    public function test_details_update_resource(): void
    {
        $contact = Detail::factory()->create();

        // Generate new data for updating the user
        $newData = [
            'key' => 'skype',
            'value' => 'test.skype.account',
        ];

        // Send a PUT request to update the user
        $response = $this->put('/api/details/'.$contact->id, $newData);

        // Assert that the request was successful (status code 200)
        $response->assertStatus(200);

        // Assert that the user was updated with the new data
        $this->assertDatabaseHas('details', [
            'id' => $contact->id,
            'key' => $newData['key'],
            'value' => $newData['value'],
        ]);
    }

    /**
     * Test Store data and check the response
     */
    public function test_details_store_resource(): void
    {
        $response = $this->postJson('/api/details',
            [
                'key' => 'email',
                'value' => 'test.elektro@test.com',
                'contact_id' => 1,
            ]
        );

        $response->assertStatus(201)
            ->assertJsonPath('data.key', 'email')
            ->assertJsonPath('data.value', 'test.elektro@test.com')
            ->assertJsonPath('data.contact_id', 1)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(
                [
                    'data.key',
                    'data.value',
                    'data',
                    'meta',
                    'meta.message',
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
