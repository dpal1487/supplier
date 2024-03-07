<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
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
            'id' => $this->wallet_id,
            'date' => $this->date,
            'points' => $this->points,
            'status' => $this->status,
            'comments' => $this->comments,
            'current_points' => $this->current_points,
            'type' => $this->type,
        ];
    }
}
