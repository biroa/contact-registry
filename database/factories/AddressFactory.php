<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Contact;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    protected const COUNTIES =
        [
            'Bács-Kiskun',
            'Baranya',
            'Békés',
            'Borsod-Abaúj-Zemplén',
            'Csongrád-Csanád',
            'Fejér',
            'Győr-Moson-Sopron',
            'Hajdú-Bihar',
            'Heves',
            'Jász-Nagykun-Szolnok',
            'Komárom-Esztergom',
            'Nógrád',
            'Pest',
            'Somogy',
            'Szabolcs-Szatmár-Bereg',
            'Tolna',
            'Vas',
            'Veszprém',
            'Zala',
        ];

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'country' => $this->faker->country(),
            'county' => $this->faker->randomElement(self::COUNTIES),
            'settlement' => $this->faker->city(),
            'street' => $this->faker->streetName(),
            'streetNumber' => $this->faker->numberBetween(1, 100),
            'contact_id' => Contact::factory(),
        ];
    }
}
