<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class IndustryResource extends JsonResource
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
            'imageUrl'=>$this['image']['file_path'],
            'name'=>$this->name,
            'status'=>$this->status,
            'created_at'=>date("d-m-Y", strtotime($this->created_at))
      ];
   }
}