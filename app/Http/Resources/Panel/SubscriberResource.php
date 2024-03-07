<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class SubscriberResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
        'id'=>$this->id,
        'email_address'=>$this->email_address,
        'ip_address'=>$this->ip_address,
        ];
    }
}