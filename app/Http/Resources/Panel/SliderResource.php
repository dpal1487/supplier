<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class SliderResource extends JsonResource
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
        'title'=>$this->title,
        'description'=>$this->description,
        'order_by'=>$this->order_by,
        'status'=>$this->status,
        'image'=>$this->image['file_path_small'],
        ];
    }
}