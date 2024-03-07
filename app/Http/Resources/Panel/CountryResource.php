<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'iso3' => $this->iso3,
            'iso2' => $this->iso2,
            'capital' => $this->capital,
            'phonecode' => $this->phonecode,
            'region' => $this->region,
            'states' => $this->states,
        ];
    }
}
