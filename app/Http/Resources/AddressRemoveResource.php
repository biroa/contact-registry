<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property mixed $country
 * @property mixed $county
 * @property mixed $settlement
 * @property mixed street
 * @property numeric streetNumber
 */
class AddressRemoveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'country' => $this->country,
            'county' => $this->county,
            'settlement' => $this->settlement,
            'street' => $this->street,
            'streetNumber' => $this->streetNumber,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'message' => 'Record is deleted successfully.',
            ],
        ];
    }
}
