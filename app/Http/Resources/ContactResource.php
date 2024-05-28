<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string,mixed>|Arrayable|JsonSerializable.
     */
    public function toArray(Request $request)
    {
        return parent::toArray($request);
    }
}
