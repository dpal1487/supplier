<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
{
   /**
    * Transform the resource collection into an array.
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
            'mobile'=>$this->mobile,
            'dob'=>$this->dob,
            'gender'=>$this->gender
      ];
   }
}