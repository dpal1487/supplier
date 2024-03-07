<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'id'=>$this->id,
        'first_name'=>$this->first_name,
        'last_name'=>$this->last_name,
        'username'=>$this->username,
        'email'=>$this->email,
        'gender'=>$this->gender,
        'dob'=>$this->dob,
        'mobile'=>$this->mobile,
        'ip_address'=>$this->ip_address,
        ];
    }
}


