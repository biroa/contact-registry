<?php

namespace Tests\Feature;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AddressResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test address index response
     */
    public function test_contacts_index_page(): void
    {
        $address = Address::factory(5)->create();
        $response = $this->get('/api/contacts/');
        $response->assertStatus(200)
            ->assertJsonCount($address->count(), 'data');
    }

    /**
     * Test address show response
     */
    public function test_addresses_show_resource(): void
    {
        $address = Address::factory()->create();
        $response = $this->get('/api/addresses/'.$address->id);
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
                    'meta.message',
                ]));
    }

    /**
     * Test Store data and check the response
     */
    public function test_address_store_resource(): void
    {
        $response = $this->postJson('/api/addresses',
            [
                'contact_id' => 1,
                'county' => 'Győr-Moson-Sopron',
                'country' => 'Magyarország',
                'settlement' => 'Győr',
                'street' => 'Teszt utca',
                'streetNumber' => 20,
            ]
        );

        $response->assertStatus(201)
            ->assertJsonPath('meta.message', 'Address stored successfully')
            ->assertJsonPath('data.county', 'Győr-Moson-Sopron')
            ->assertJsonPath('data.country', 'Magyarország')
            ->assertJsonPath('data.settlement', 'Győr')
            ->assertJsonPath('data.street', 'Teszt utca')
            ->assertJsonPath('data.streetNumber', 20)
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(
                [
                    'meta.message',
                    'data.county',
                    'data.country',
                    'data.settlement',
                    'data.street',
                    'data.streetNumber',
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
        $contact = Address::factory()->create();

        // Send a DELETE request to delete the user
        $response = $this->delete('/api/addresses/'.$contact->id);

        // Assert that the request was successful (status code 204)
        $response->assertStatus(200);
        $this->assertSoftDeleted(Address::class);
    }

    /**
     * Test updating a contact resource.
     */
    public function test_address_update_resource(): void
    {
        $contact = Address::factory()->create();

        // Generate new data for updating the user
        $newData = [
            'county' => 'Test County',
            'country' => 'Test Country',
            'settlement' => 'Test Settlement',
            'street' => 'Teszt street',
            'streetNumber' => 20,
        ];

        // Send a PUT request to update the user
        $response = $this->put('/api/addresses/'.$contact->id, $newData);

        $response->assertStatus(200);

        // Assert that the user was updated with the new data
        $this->assertDatabaseHas('addresses', [
            'county' => $newData['county'],
            'country' => $newData['country'],
            'settlement' => $newData['settlement'],
            'street' => $newData['street'],
            'streetNumber' => $newData['streetNumber'],
        ]);
    }
}
