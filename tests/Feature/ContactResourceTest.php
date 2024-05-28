<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ContactResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The main page is working
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Store data and check the response
     */
    public function test_contacts_store_resource(): void
    {
        $response = $this->postJson('/api/contacts', ['firstName' => 'Adam', 'lastName' => 'Biro']);
//        dd($response->content());
        $response->assertStatus(201)
            ->assertJsonPath('meta.message', 'Contacts stored successfully')
            ->assertJsonPath('data.firstName', 'Adam')
            ->assertJsonPath('data.lastName', 'Biro')
            ->assertJson(fn (AssertableJson $json) => $json->hasAll(
                [
                    'data.firstName',
                    'data.lastName',
                    'data',
                    'meta',
                    'meta.message'
                ]));
    }

    /**
     * Test updating a contact resource.
     */
    public function test_contacts_update_resource(): void
    {
        $contact = Contact::factory()->create();

        // Generate new data for updating the user
        $newData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        // Send a PUT request to update the user
        $response = $this->put('/api/contacts/'.$contact->id, $newData);

        // Assert that the request was successful (status code 200)
        $response->assertStatus(200);

        // Assert that the user was updated with the new data
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'firstName' => $newData['firstName'],
            'lastName' => $newData['lastName'],
        ]);
    }

    /**
     * Test delete a contact resource.
     *
     * @return void
     */
    public function test_soft_delete_resource()
    {
        $contact = Contact::factory()->create();

        // Send a DELETE request to delete the user
        $response = $this->delete('/api/contacts/'.$contact->id);

        // Assert that the request was successful (status code 204)
        $response->assertStatus(200);
        $this->assertSoftDeleted(Contact::class);
    }
}
