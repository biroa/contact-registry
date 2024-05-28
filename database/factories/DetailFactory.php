<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Detail;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Detail::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $data = [
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'facebook' => $this->faker->url(),
        ];

        $keys = array_keys($data);
        $randomKey = array_rand($keys);

        return [
            'key' => $keys[$randomKey],
            'value' => $data[$keys[$randomKey]],
            'contact_id' => Contact::factory(),
        ];
    }
}
