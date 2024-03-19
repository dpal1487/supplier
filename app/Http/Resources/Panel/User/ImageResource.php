<?php

namespace App\Http\Resources\Panel\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'entity_id' => $this->entity_id,
            'user_id' => $this->user_id,
            'url' => asset("/images/$this->entity_type") . '/' . $this->name,
        ];
    }
}
