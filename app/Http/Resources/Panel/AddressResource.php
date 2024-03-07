<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'address' => $this->address ?? 'N/A',
            'city' => $this->city ?? 'N/A',
            'pincode' => $this->pincode ?? 'N/A',
            'country' => $this->country,
            'state' => $this->state,
        ];
    }
}
